<?php

require '../../frontend/header.php';
include 'db.php';

$message = "";

// --------------- Update Table Status ---------------
if (isset($_POST['update_table_status'])) {
    $table_id = (int)$_POST['table_id'];
    $table_status = $_POST['table_status'];
    $waiter_id = (int)$_POST['waiter_id'];

    // Update table status and assign waiter
    $stmt = $conn->prepare("UPDATE Tables SET Table_status=?, Waiter_id=? WHERE Table_id=?");
    $stmt->bind_param("sii", $table_status, $waiter_id, $table_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Table #$table_id updated!";
    } else {
        $_SESSION['message'] = "Error updating table: " . $conn->error;
    }

    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// --------------- Delete Prepared Order ---------------
if (isset($_POST['delete_order'])) {
    $order_id = (int)$_POST['order_id'];
    $waiter_id = (int)$_POST['waiter_id'];

    // Optional: check if the waiter is assigned to the table
    $stmt_check = $conn->prepare("SELECT Table_id FROM Orders WHERE Order_id=?");
    $stmt_check->bind_param("i", $order_id);
    $stmt_check->execute();
    $stmt_check->bind_result($table_id);
    $stmt_check->fetch();
    $stmt_check->close();

    // Delete order
    $stmt_del = $conn->prepare("DELETE FROM Orders WHERE Order_id=? AND Order_status='Prepared'");
    $stmt_del->bind_param("i", $order_id);

    if ($stmt_del->execute()) {
        $_SESSION['message'] = "Prepared Order #$order_id served and deleted!";
    } else {
        $_SESSION['message'] = "Error deleting order: " . $conn->error;
    }

    $stmt_del->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// --------------- Fetch Tables and Orders ---------------
$tables = $conn->query("SELECT t.Table_id, t.Table_number, t.Table_status, w.Waiter_name, t.Waiter_id
                        FROM Tables t 
                        LEFT JOIN Waiter w ON t.Waiter_id=w.Waiter_id
                        ORDER BY t.Table_number ASC");

$preparingOrders = $conn->query("SELECT * FROM Orders WHERE Order_status='Preparing' ORDER BY Order_date ASC");
$preparedOrders = $conn->query("SELECT o.Order_id, o.Table_id, o.Total_amount, o.Order_items, t.Table_number
                                FROM Orders o 
                                JOIN Tables t ON o.Table_id=t.Table_id
                                WHERE o.Order_status='Prepared'
                                ORDER BY o.Order_date ASC");

if (isset($_SESSION['message'])) {
    echo "<div class='p-3 text-green-800 text-center font-bold mb-4'>
            {$_SESSION['message']}
          </div>";
    unset($_SESSION['message']);
}