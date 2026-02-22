<?php
require '../../frontend/header.php';
include 'db.php';

if (!isset($_SESSION['payment_id']) || !isset($_SESSION['order_id'])) {
    die("No payment found. Please place an order first.");
}

$payment_id = (int)$_SESSION['payment_id'];
$order_id = (int)$_SESSION['order_id'];

$latest_payment = $conn->prepare("SELECT p.*, c.Cashier_name FROM Payment p LEFT JOIN Cashier c ON p.Cashier_id = c.Cashier_id WHERE Payment_id = ?");
$latest_payment->bind_param("i", $payment_id);
$latest_payment->execute();
$payment_result = $latest_payment->get_result();
$payment = $payment_result->fetch_assoc();

if (!$payment) {
    die("Payment not found.");
}

//get order
$order_stmt = $conn->prepare("SELECT * FROM Orders WHERE Order_id = ?");
$order_stmt->bind_param("i", $order_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
$order = $order_result->fetch_assoc();
//if no order
if (!$order) {
    die("Order not found.");
}

//values to show
$items_raw = $order['Order_items'];
$items_array = explode(", ", $items_raw);
$customer_type = $order['Customer_type'] ?? 'Regular';
$total_amount = $order['Total_amount'] ?? 0;
$amount_paid = $payment['Amount_paid'] ?? 0;
$change = $amount_paid - $total_amount;
$payment_method = $payment['Payment_method'] ?? 'Unknown';
$status = $payment['Payment_status'] ?? 'Pending';
$transaction_date = $payment['Payment_date'] ?? date('Y-m-d H:i:s');
$transaction_num = $payment['Transaction_Num'] ?? 'TXN-' . rand(100000, 999999);
$cashier_name = $payment['Cashier_name'] ?? 'Unknown';
?>