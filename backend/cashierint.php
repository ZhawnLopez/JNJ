<?php
session_start();
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
        $_SESSION['cart'][] = ['dish_id' => $dish_id, 'quantity' => $quantity];
        $message = "Dish added to cart!";
    }
}

// remove from cart
if (isset($_POST['remove_from_cart'])) {
    $index = (int)$_POST['cart_index'];

    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        $message = "Item removed from cart!";
    }
}

// place orders
if (isset($_POST['place_order'])) {

    $customer_id = (int)$_POST['customer_id'];
    $cashier_id = (int)$_POST['cashier_id'];
    $table_id = (int)$_POST['table_id'];

    if (!empty($_SESSION['cart'])) {

        $total_amount = 0;

        foreach ($_SESSION['cart'] as $item) {
            $dish_id = (int)$item['dish_id'];
            $quantity = (int)$item['quantity'];

            $result = $conn->query("SELECT Price FROM Dish WHERE Dish_id=$dish_id");

            if ($result && $dish = $result->fetch_assoc()) {
                $total_amount += $dish['Price'] * $quantity;
            } else {
                $message = "Dish ID $dish_id not found.";
                break;
            }
        }

        if (empty($message)) {

            $order_items_json = json_encode($_SESSION['cart']);

            $insert = $conn->query("
                INSERT INTO Orders (Order_items, Total_amount, Table_id, Cashier_id, Customer_id) 
                VALUES ('$order_items_json', $total_amount, $table_id, $cashier_id, $customer_id)
            ");

            if ($insert) {
                $order_id = $conn->insert_id;
                $_SESSION['cart'] = [];
                $message = "Order placed! Order ID: $order_id | Total: ₱$total_amount";
            } else {
                $message = "Order error: " . $conn->error;
            }
        }

    } else {
        $message = "Cart is empty!";
    }
}

// payment processings
if (isset($_POST['pay_order'])) {

    $order_id = (int)$_POST['order_id'];
    $customer_id = (int)$_POST['customer_id'];
    $cashier_id = (int)$_POST['cashier_id'];
    $payment_method = $_POST['payment_method'];
    $amount_paid = (float)$_POST['amount_paid'];

    $pay = $conn->query("
        INSERT INTO Payment 
        (Order_id, Amount_paid, Payment_method, Payment_status, Cashier_id, Customer_id)
        VALUES 
        ($order_id, $amount_paid, '$payment_method', 'Paid', $cashier_id, $customer_id)
    ");

    if ($pay) {
        $conn->query("UPDATE Orders SET Order_status='Prepared' WHERE Order_id=$order_id");
        $message = "Payment successful!";
    } else {
        $message = "Payment error: " . $conn->error;
    }
}
$dishes = $conn->query("SELECT Dish_id, Dish_name, Price FROM Dish WHERE Availability_status='Available'");
$customers = $conn->query("SELECT Customer_id, Customer_name, Customer_type FROM Customer");

// most recent customer
// this is to make it auto select the most recent for Payment and Order
$latestCustomerResult = $conn->query("SELECT Customer_id FROM Customer ORDER BY Customer_id DESC LIMIT 1");
$latestCustomer = $latestCustomerResult ? $latestCustomerResult->fetch_assoc() : null;
$latestCustomerId = $latestCustomer ? $latestCustomer['Customer_id'] : null;

// unpaid orders for payment
$unpaidOrders = $conn->query("
    SELECT Order_id, Total_amount 
    FROM Orders 
    WHERE Order_status != 'Prepared'
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cashier Interface</title>
    <style>
        table { border-collapse: collapse; width: 60%; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 8px; }
    </style>
</head>
<body>

<h1>Cashier Interface</h1>

<?php if (!empty($message)) echo "<p><strong>$message</strong></p>"; ?>

<!-- available dishes -->
<h2>Available Dishes</h2>
<table>
<tr><th>Name</th><th>Price</th><th>Action</th></tr>
<?php while($row = $dishes->fetch_assoc()): ?>
<tr>
    <td><?= $row['Dish_name'] ?></td>
    <td>₱<?= number_format($row['Price'],2) ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="dish_id" value="<?= $row['Dish_id'] ?>">
            <input type="number" name="quantity" value="1" min="1">
            <button type="submit" name="add_to_cart">Add</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>
</table>

<!-- cart -->
<h2>Cart</h2>

<?php if (!empty($_SESSION['cart'])): ?>
<table>
<tr><th>Dish</th><th>Qty</th><th>Action</th></tr>
<?php foreach ($_SESSION['cart'] as $index => $item): 
    $dish_id = (int)$item['dish_id'];
    $result = $conn->query("SELECT Dish_name FROM Dish WHERE Dish_id=$dish_id");
    $dish = $result ? $result->fetch_assoc() : null;
?>
<tr>
    <td><?= $dish ? $dish['Dish_name'] : 'Unknown' ?></td>
    <td><?= $item['quantity'] ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="cart_index" value="<?= $index ?>">
            <button type="submit" name="remove_from_cart">Remove</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>

<!-- place order -->
<h3>Place Order</h3>
<form method="POST">
    Customer:
    <select name="customer_id" required>
        <?php while($c = $customers->fetch_assoc()): ?>
            <option value="<?= $c['Customer_id'] ?>"
                <?= ($c['Customer_id'] == $latestCustomerId) ? 'selected' : '' ?>>
                <?= $c['Customer_name'] ?> (<?= $c['Customer_type'] ?>)
            </option>
        <?php endwhile; ?>
    </select>
    <br><br>

    Cashier ID:
    <select name="cashier_id" required>
        <?php for ($i=1;$i<=5;$i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor; ?>
    </select>
    <br><br>

    Table ID:
    <select name="table_id" required>
        <?php for ($i=11;$i<=15;$i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor; ?>
    </select>
    <br><br>

    <button type="submit" name="place_order">Place Order</button>
</form>
<?php else: ?>
<p>Cart is empty.</p>
<?php endif; ?>

<!-- payment -->
<h2>Payment</h2>
<form method="POST">
    Order:
    <select name="order_id" required>
        <?php 
        $unpaidOrders = $conn->query("
            SELECT Order_id, Total_amount 
            FROM Orders 
            WHERE Order_status != 'Prepared'
        ");
        while($o = $unpaidOrders->fetch_assoc()): ?>
            <option value="<?= $o['Order_id'] ?>">
                Order #<?= $o['Order_id'] ?> - ₱<?= number_format($o['Total_amount'],2) ?>
            </option>
        <?php endwhile; ?>
    </select>
    <br><br>

    <!-- select customer (default most recent) -->
    Customer:
    <select name="customer_id" required>
        <?php
        $customers = $conn->query("SELECT Customer_id, Customer_name, Customer_type FROM Customer");
        // get most recently added customer
        $latestCustomerResult = $conn->query("SELECT Customer_id FROM Customer ORDER BY Customer_id DESC LIMIT 1");
        $latestCustomer = $latestCustomerResult ? $latestCustomerResult->fetch_assoc() : null;
        $latestCustomerId = $latestCustomer ? $latestCustomer['Customer_id'] : null;

        while($c = $customers->fetch_assoc()): ?>
            <option value="<?= $c['Customer_id'] ?>"
                <?= ($c['Customer_id'] == $latestCustomerId) ? 'selected' : '' ?>>
                <?= $c['Customer_name'] ?> (<?= $c['Customer_type'] ?>)
            </option>
        <?php endwhile; ?>
    </select>
    <br><br>

    Cashier ID:
    <select name="cashier_id" required>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor; ?>
    </select>
    <br><br>

    Payment Method:
    <select name="payment_method">
        <option value="Cash">Cash</option>
        <option value="Gcash">Gcash</option>
        <option value="Paymaya">Paymaya</option>
    </select>
    <br><br>

    Amount Paid: <input type="number" step="0.01" name="amount_paid" required><br><br>

    <button type="submit" name="pay_order">Pay</button>
</form>



</body>
</html>
