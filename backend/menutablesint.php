<?php
require '../../frontend/header.php';
include 'db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['manager_id']) || $_SESSION['role'] !== 'admin') {
    // Destroy session for safety
    session_unset();
    session_destroy();

    // Redirect to login page
    header("Location: verify.php");
    exit();
}
// ---------------------- Handle Dish Actions ----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    $name = $_POST['dish_name'] ?? '';
    $category = $_POST['dish_category'] ?? '';
    $price = (float)($_POST['price'] ?? 0);
    $prep_time = (int)($_POST['prep_time'] ?? 0);
    $availability = $_POST['availability_status'] ?? 'Available';
    $ingredients = $_POST['ingredients'] ?? '';

    $capacity = (int)($_POST['table_capacity'] ?? 0);
    $status = $_POST['table_status'] ?? '';
    $waiter_id = $_POST['waiter_id'] ?? '';

    if ($action === 'addDish') {
        $stmt = $conn->prepare("INSERT INTO Dish (Dish_name, Dish_category, Price, Preparation_timeMin, Availability_status, Ingredients) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssidss', $name, $category, $price, $prep_time, $availability, $ingredients);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if ($action === 'editDish') {
        $dish_id = (int)$_POST['dish_id'];
        $stmt = $conn->prepare("UPDATE Dish SET Dish_name=?, Dish_category=?, Price=?, Preparation_timeMin=?, Availability_status=?, Ingredients=? WHERE Dish_id=?");
        $stmt->bind_param('ssidssi', $name, $category, $price, $prep_time, $availability, $ingredients, $dish_id);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if ($action === 'deleteDish') {
        $dish_id = (int)$_POST['dish_id'];
        $conn->query("DELETE FROM Dish WHERE Dish_id=$dish_id");
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if ($action === 'addTable') {
        $stmt = $conn->prepare("INSERT INTO Tables (Table_capacity, Table_status, Waiter_id) VALUES (?, ?, ?)");
        $stmt->bind_param('isi', $capacity, $status, $waiter_id);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if ($action === 'editTable') {
        $table_id = (int)$_POST['table_id'];
        $stmt = $conn->prepare("UPDATE Tables SET Table_capacity=?, Table_status=?, Waiter_id=? WHERE Table_id=?");
        $stmt->bind_param('isii',$capacity, $status, $waiter_id, $table_id);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if ($action === 'deleteTable') {
        $table_id = (int)$_POST['table_id'];
        $conn->query("DELETE FROM Tables WHERE Table_id=$table_id");
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// ---------------------- Fetch Tables ----------------------
$dishes = $conn->query("SELECT * FROM Dish ORDER BY Dish_id ASC");
$tables = $conn->query("SELECT t.*, w.Waiter_name, w.Waiter_id FROM Tables t LEFT JOIN Waiter w ON t.Waiter_id = w.Waiter_id ORDER BY Table_id ASC");
$waiters = $conn->query("SELECT Waiter_name, Waiter_id  FROM Waiter ORDER BY Waiter_id ASC");