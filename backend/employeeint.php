<?php
require '../../frontend/header.php';
include 'db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
$message = "";
// ---------------------- Handle Employee Registration ----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

   if ($action === 'register') {
        $type = $_POST['employee_type'] ?? '';
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $shift = $_POST['shift'] ?? '';
        $date_hired = $_POST['date_hired'] ?? '';

        if ($type === 'Cashier') {
            $total_transactions = (int)($_POST['total_transactions'] ?? 0);
            $stmt = $conn->prepare("INSERT INTO Cashier (Cashier_name,Cashier_email,Cashier_contact_num,Cashier_shift,Date_hired,Total_transactions) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssi', $name, $email, $contact, $shift, $date_hired, $total_transactions);
            $stmt->execute();
            $stmt->close();
        } elseif ($type === 'Waiter') {
            $stmt = $conn->prepare("INSERT INTO Waiter (Waiter_name,Waiter_email,Waiter_contact_num,Waiter_shift,Date_hired) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('sssss', $name, $email, $contact, $shift, $date_hired);
            $stmt->execute();
            $stmt->close();
        } elseif ($type === 'Chef') {
            $speciality = $_POST['speciality'] ?? '';
            $years_experience = (int)($_POST['years_experience'] ?? 0);
            $stmt = $conn->prepare("INSERT INTO Chef (Chef_name,Chef_email,Chef_contact_num,Speciality,Chef_shift,Date_hired, Years_of_experience) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssssi', $name, $email, $contact, $speciality, $shift, $date_hired, $years_experience);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } elseif ($action === 'edit') {
        // Update existing employee
        $type = $_POST['employee_type'];
        $id = (int)$_POST['employee_id'];
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $shift = $_POST['shift'] ?? '';
        $date_hired = $_POST['date_hired'] ?? '';

        if ($type === 'Cashier') {
            $total_transactions = (int)($_POST['total_transactions'] ?? 0);
            $stmt = $conn->prepare("UPDATE Cashier SET Cashier_name=?,Cashier_email=?,Cashier_contact_num=?,Cashier_shift=?,Date_hired=?,Total_transactions=? WHERE Cashier_id=?");
            $stmt->bind_param('sssssii', $name,$email,$contact,$shift,$date_hired,$total_transactions,$id);
            $stmt->execute();
            $stmt->close();
        } elseif ($type === 'Waiter') {
            $stmt = $conn->prepare("UPDATE Waiter SET Waiter_name=?,Waiter_email=?,Waiter_contact_num=?,Waiter_shift=?,Date_hired=? WHERE Waiter_id=?");
            $stmt->bind_param('sssssi',$name,$email,$contact,$shift,$date_hired,$id);
            $stmt->execute();
            $stmt->close();
        } elseif ($type === 'Chef') {
            $speciality = $_POST['speciality'] ?? '';
            $years_experience = (int)($_POST['years_experience'] ?? 0);
            $stmt = $conn->prepare("UPDATE Chef SET Chef_name=?,Chef_email=?,Chef_contact_num=?,Speciality=?,Chef_shift=?,Date_hired=?,Years_of_experience=? WHERE Chef_id=?");
            $stmt->bind_param('ssssssii',$name,$email,$contact,$speciality,$shift,$date_hired,$years_experience,$id);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();

    } elseif ($action === 'delete') {
        $type = $_POST['employee_type'];
        $id = (int)$_POST['employee_id'];

        if ($type === 'Cashier') $conn->query("DELETE FROM Cashier WHERE Cashier_id=$id");
        elseif ($type === 'Waiter') $conn->query("DELETE FROM Waiter WHERE Waiter_id=$id");
        elseif ($type === 'Chef') $conn->query("DELETE FROM Chef WHERE Chef_id=$id");
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
// SELECT TABLES FOR VIEWING
$cashiers = $conn->query("SELECT * FROM Cashier ORDER BY Cashier_id ASC");
$waiters = $conn->query("SELECT * FROM Waiter ORDER BY Waiter_id ASC");
$chefs = $conn->query("SELECT * FROM Chef ORDER BY Chef_id ASC");