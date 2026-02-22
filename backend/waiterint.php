<?php

require '../../frontend/header.php';
include 'db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
$message = "";

// --------------- Update Table Status ---------------
if (isset($_POST['update_table_status'])) {
    $table_id = (int)$_POST['table_id'];
    $table_status = $_POST['table_status'];
    $waiter_id = (int)$_POST['waiter_id'];

    $stmt = $conn->query("UPDATE Tables SET Table_status='$table_status', Waiter_id=$waiter_id WHERE Table_id=$table_id");
    if ($stmt) {
        $_SESSION['message'] = "Table #$table_id updated!";
    } else {
        $_SESSION['message'] = "Error updating table: " . $conn->error;
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// --------------- Delete Prepared Order ---------------
if (isset($_POST['delete_order'])) {
    $order_id = (int)$_POST['order_id'];
    $waiter_id = (int)$_POST['waiter_id'];
    $stmt_serve = $conn->query("UPDATE Orders SET Order_status = 'Served' WHERE Order_id = $order_id");
    if ($stmt_serve) {
        $_SESSION['message'] = "Order #$order_id successfully served!";
    } else {
        $_SESSION['message'] = "Error updating order: " . $conn->error;
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// --------------- Fetch Tables
$tables = $conn->query("SELECT * FROM Tables ORDER BY Table_id ASC");
$waiterList = $conn->query("SELECT Waiter_id FROM Waiter ORDER BY Waiter_id ASC");
$preparingOrders = $conn->query("SELECT * FROM Orders WHERE Order_status='Preparing' ORDER BY Order_date ASC");
$preparedOrders = $conn->query("SELECT * FROM Orders WHERE Order_status='Prepared' ORDER BY Order_date ASC");   