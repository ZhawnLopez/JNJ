<?php
require '../../frontend/header.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';

$message = "";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// add to cart
if (isset($_POST['add_to_cart'])) {
    $dish_id = (int)$_POST['dish_id'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity > 0) {
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['dish_id'] === $dish_id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        unset($item); 
        if (!$found) {
            $_SESSION['cart'][] = [
                'dish_id' => $dish_id,
                'quantity' => $quantity
            ];
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// remove from cart
if (isset($_POST['remove_from_cart'])) {
    $index = (int)$_POST['cart_index'];

    if (isset($_SESSION['cart'][$index])) {
        // Decrease 
        $_SESSION['cart'][$index]['quantity']--;
        // If quantity is now 0 or less, remove item
        if ($_SESSION['cart'][$index]['quantity'] <= 0) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            $message = "Item removed from cart!";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
if(isset($_POST['delete_from_cart'])){
    $index = (int)$_POST['cart_index'];

    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        $message = "Item removed from cart!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
//-----------------pay order
if (isset($_POST['pay_order'])) {
    $cashier_id = (int)$_POST['cashier_id'];
    $table_id = (int)$_POST['table_id'];
    $payment_method = $_POST['payment_method'];
    $amount_paid = (float)$_POST['amount_paid'];
    $transaction_num = trim($_POST['transaction_num']) ?? '';
    $customer_type = $_POST['customer_type'] ?? 'Regular';

    if (!empty($_SESSION['cart'])) {
        $total_amount = 0;
        $order_items_text = [];

        //get total per dish
        foreach ($_SESSION['cart'] as $item) {
            $dish_id = (int)$item['dish_id'];
            $qty = (int)$item['quantity'];
            
            $res = $conn->query("SELECT Dish_name, Price FROM Dish WHERE Dish_id=$dish_id");
            if ($row = $res->fetch_assoc()) {
                $total_amount += (float)$row['Price'] * $qty;
                //text array for order_items
                $order_items_text[] = $row['Dish_name'] . " x" . $qty;
            }
        }

        //pwd discount
        if ($customer_type === 'PWD') {
            $total_amount = $total_amount * 0.80; 
        }

        //paid amount must be greater than total amount
        if ($amount_paid < $total_amount) {
            $_SESSION['message'] = "Insufficient amount! Total: ₱" . number_format($total_amount, 2);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            //text array of order items
            $order_items_string = $conn->real_escape_string(implode(", ", $order_items_text));

            //insert order
            $insertOrder = $conn->query("INSERT INTO Orders (Order_items, Total_amount, Customer_type, Table_id, Cashier_id, Order_status) VALUES ('$order_items_string', $total_amount, '$customer_type', $table_id, $cashier_id, 'Preparing')");

            if ($insertOrder) {
                $new_order_id = $conn->insert_id;

                // insert payment
                $pay = $conn->query("INSERT INTO Payment (Order_id, Amount_paid, Payment_method, Payment_status, Transaction_Num, Cashier_id) VALUES ($new_order_id, $amount_paid, '$payment_method', 'Paid', '$transaction_num', $cashier_id)");

                if ($pay) {
                    $_SESSION['cart'] = [];
                    $_SESSION['message'] = "Order #$new_order_id paid successfully!";
                    $_SESSION['payment_id'] = $conn->insert_id;
                    $_SESSION['order_id'] = $new_order_id;
                    header('Location: ../../frontend/Cashier/payment.php');
                    exit();
                } else {
                    $message = "Payment Error: " . $conn->error;
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                }
            } else {
                $message = "Order Error: " . $conn->error;
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    } else {
        $message = "Your cart is empty!";
    }
}

$dishes = $conn->query("SELECT Dish_id, Dish_name, Price FROM Dish WHERE Availability_status='Available'");
$cashiers = $conn->query("SELECT Cashier_id FROM Cashier");
$availtables = $conn->query("SELECT Table_id FROM Tables");
?>

