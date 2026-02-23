<?php
require '../../frontend/header.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';
// Fetch all dishes
$dishes = $conn->query("SELECT Dish_id, Dish_name, Preparation_timeMin, Ingredients FROM Dish ORDER BY Dish_name ASC");
if (!$dishes) {
    die("Error fetching dishes: " . $conn->error);
}

// Get selected dish
$selected_dish_id = null;
$selected_dish = null;
$message = "";

if (isset($_POST['update_ingredient'])) {
    $ingredient_id = (int)$_POST['ingredient_id'];
    $restock_status = $_POST['restock_status'];
    $chef_id = (int)$_POST['chef_id'];
    $fields = [];
    
    if ($restock_status !== null) {
        $fields[] = "Restock_status='$restock_status'";
    }
    if (isset($_POST['quantity_available']) && $_POST['quantity_available'] !== '') {
        $quantity = (int)$_POST['quantity_available'];
        $fields[] = "Quantity_available=$quantity";
    }
    // Always update chef + timestamp
    $fields[] = "Chef_id=$chef_id";
    $fields[] = "Status_updated=NOW()";
    $sql = "UPDATE Ingredients SET " . implode(", ", $fields) . " WHERE Ingredients_id=$ingredient_id";
    $update = $conn->query($sql);
    $message = $update ? "Ingredient updated!" : "Update failed: " . $conn->error;
}

if (isset($_POST['take_order'])) {
    $order_id = (int)$_POST['order_id'];
    $chef_id = (int)$_POST['chef_id'];
    $update = $conn->query("UPDATE Chef SET Order_id = $order_id WHERE Chef_id = $chef_id");
    $conn->query("UPDATE Chef SET Order_id=$order_id WHERE Chef_id=$chef_id");
    if ($update) {
        $_SESSION['message'] = "Order #$order_id is now being prepared by Chef #$chef_id";
    } else {
        $_SESSION['message'] = "Error assigning order: " . $conn->error;
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['mark_prepared'])) {
    $order_id = (int)$_POST['order_id'];
    $chef_id = (int)$_POST['chef_id'];
    $unsetChef = $conn->query("UPDATE Chef SET Order_id = NULL WHERE Chef_id = $chef_id");
    $updateOrder = $conn->query("UPDATE Orders SET Order_status = 'Prepared' WHERE Order_id = $order_id");
    if ($unsetChef && $updateOrder) {
        $_SESSION['message'] = "Order #$order_id is now Prepared";
    } else {
        $_SESSION['message'] = "Error finishing order: " . $conn->error;
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dish_id'])) {
    $selected_dish_id = (int)$_POST['dish_id'];
    // Fetch the dish to get the ingredients column
    $stmt = $conn->prepare("SELECT Dish_name, Ingredients, Preparation_timeMin, Dish_category FROM Dish WHERE Dish_id = ?");
    $stmt->bind_param("i", $selected_dish_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $selected_dish = $result->fetch_assoc();
    $stmt->close();
}

// gets Orders being prepped/notready, gets Chef name, makes sure that each Order is being prepped by a Chef basically
// if chef is prepping an order, it shows chef name, if no chef is on an order , that order will still be there in the results just waiting for a chef
// DAMN I CANNOT EXPLAIN STUFF
$ingredients = $conn->query("SELECT i.*, c.Chef_name, c.Chef_id 
                                FROM Ingredients i 
                                JOIN Chef c ON i.Chef_id = c.Chef_id 
                                ORDER BY i.Ingredients_id ASC");

//orders that have not yet been accepted by any chefs
$newOrders = $conn->query("SELECT * FROM Orders WHERE Order_id NOT IN (SELECT Order_id FROM Chef WHERE Order_id IS NOT NULL) AND Order_status = 'Preparing'");
//preparing orders should be orders WITH CHEF ID
$preparingOrders = $conn->query("SELECT o.*, c.Chef_name, c.Chef_id FROM Orders o JOIN Chef c ON o.Order_id = c.Order_id WHERE o.Order_status = 'Preparing'");
$availableChefs = $conn->query("SELECT Chef_id, Chef_name FROM Chef WHERE Order_id IS NULL");
$chefs = $conn->query("SELECT Chef_id FROM Chef ORDER BY Chef_id ASC");
?>