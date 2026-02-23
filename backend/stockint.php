<?php
require '../../frontend/header.php';
include 'db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
$message = "";
if (!isset($_SESSION['manager_id']) || $_SESSION['role'] !== 'admin') {
    // Destroy session for safety
    session_unset();
    session_destroy();

    // Redirect to login page
    header("Location: verify.php");
    exit();
}
// ---------------------- Handle Ingredient Add/Edit ----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add') {
        $name = $_POST['ingredient_name'] ?? '';
        $category = $_POST['category'] ?? '';
        $quantity = (int)($_POST['quantity'] ?? 0);
        $unit = $_POST['unit'] ?? '';
        $date_received = $_POST['date_received'] ?? null;
        $expiry = $_POST['expiry_date'] ?? null;
        $restock_status = $_POST['restock_status'] ?? 'Good';
        $chef_id = (int)($_POST['chef_id'] ?? 0);

        $stmt = $conn->prepare("INSERT INTO Ingredients 
            (Ingredients_name, Category, Quantity_available, Unit_of_measure, Date_received, Expiry_date, Restock_status, Chef_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssssi', $name, $category, $quantity, $unit, $date_received, $expiry, $restock_status, $chef_id);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']); exit();
    } elseif ($action === 'edit') {
        $id = (int)($_POST['ingredient_id'] ?? 0); // original ID
        $name = $_POST['ingredient_name'] ?? '';
        $category = $_POST['category'] ?? '';
        $quantity = (int)($_POST['quantity'] ?? 0);
        $unit = $_POST['unit'] ?? '';
        $date_received = $_POST['date_received'] ?? null;
        $expiry = $_POST['expiry_date'] ?? null;
        $restock_status = $_POST['restock_status'] ?? 'Good';
        $chef_id = (int)($_POST['chef_id'] ?? 0);

        $stmt = $conn->prepare("UPDATE Ingredients SET 
           Ingredients_name=?, Category=?, Quantity_available=?, Unit_of_measure=?, Date_received=?, Expiry_date=?, Restock_status=?, Chef_id=? 
            WHERE Ingredients_id=?");
        $stmt->bind_param('ssissssii', $name, $category, $quantity, $unit, $date_received, $expiry, $restock_status, $chef_id, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']); exit();
    } elseif ($action === 'delete') {
        $id = (int)($_POST['ingredient_id'] ?? 0);
        $conn->query("DELETE FROM Ingredients WHERE Ingredients_id=$id");
        header("Location: " . $_SERVER['PHP_SELF']); exit();
    }
}

// Fetch ingredients for table
$ingredients = $conn->query("SELECT i.*, c.Chef_name FROM Ingredients i JOIN Chef c ON i.Chef_id = c.Chef_id ORDER BY Ingredients_id ASC");
$chefs = $conn->query("SELECT Chef_id, Chef_name FROM Chef ORDER BY Chef_id ASC");