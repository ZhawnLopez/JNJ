<?php
require '../../frontend/header.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';

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
    $update = $conn->query("UPDATE Orders SET Chef_id=$chef_id WHERE Order_id=$order_id AND (Chef_id IS NULL OR Chef_id=0)");
    $message = $update ? "Order #$order_id taken!" : "Failed to take order: " . $conn->error;
}

if (isset($_POST['mark_prepared'])) {
    $order_id = (int)$_POST['order_id'];
    $update = $conn->query("UPDATE Orders SET Order_status='Prepared'WHERE Order_id=$order_id");
    $message = $update ? "Order #$order_id marked as Prepared!" : "Failed to update order: " . $conn->error;
}

// gets Orders being prepped/notready, gets Chef name, makes sure that each Order is being prepped by a Chef basically
// if chef is prepping an order, it shows chef name, if no chef is on an order , that order will still be there in the results just waiting for a chef
// DAMN I CANNOT EXPLAIN STUFF
$ingredients = $conn->query("SELECT i.*, c.Chef_name, c.Chef_id FROM Ingredients i JOIN Chef c ON i.Chef_id = c.Chef_id ORDER BY i.Ingredients_id ASC");
$preparingOrders = $conn->query("SELECT o.*, c.Chef_name FROM Orders o LEFT JOIN Chef c ON o.Chef_id = c.Chef_id WHERE o.Order_status='Preparing'ORDER BY o.Order_id ASC");
$chefs = $conn->query("SELECT Chef_id FROM Chef ORDER BY Chef_id ASC");
?>