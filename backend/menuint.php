<?php
require '../../frontend/header.php';
include 'db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
// ---------------------- Handle Dish Actions ----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    $name = $_POST['dish_name'] ?? '';
    $category = $_POST['dish_category'] ?? '';
    $price = (float)($_POST['price'] ?? 0);
    $prep_time = (int)($_POST['prep_time'] ?? 0);
    $availability = $_POST['availability_status'] ?? 'Available';
    $ingredients = $_POST['ingredients'] ?? '';

    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO Dish (Dish_name, Dish_category, Price, Preparation_timeMin, Availability_status, Ingredients) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssidss', $name, $category, $price, $prep_time, $availability, $ingredients);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if ($action === 'edit') {
        $dish_id = (int)$_POST['dish_id'];
        $stmt = $conn->prepare("UPDATE Dish SET Dish_name=?, Dish_category=?, Price=?, Preparation_timeMin=?, Availability_status=?, Ingredients=? WHERE Dish_id=?");
        $stmt->bind_param('ssidssi', $name, $category, $price, $prep_time, $availability, $ingredients, $dish_id);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if ($action === 'delete') {
        $dish_id = (int)$_POST['dish_id'];
        $conn->query("DELETE FROM Dish WHERE Dish_id=$dish_id");
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// ---------------------- Fetch Dishes ----------------------
$dishes = $conn->query("SELECT * FROM Dish ORDER BY Dish_id ASC");