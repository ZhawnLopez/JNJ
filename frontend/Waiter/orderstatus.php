
<?php
require '../header.php';
include '../../backend/db.php';

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
    echo "<div class='p-3 bg-green-200 text-green-800 text-center font-bold mb-4'>
            {$_SESSION['message']}
          </div>";
    unset($_SESSION['message']);
}
?>
    <p>Prepared Orders</p>
</nav>
<section class="min-h-screen flex flex-1 overflow-hidden">
<div class="flex flex-col flex-1">
    <!-- ----------------- PREPARING ORDERS ----------------- -->
    <div class="flex-1 m-8 bg-gray-300 rounded-lg p-4 shadow-lg overflow-y-auto">
        <h1 class="font-bold text-center text-2xl pb-4 border-b mb-4">Preparing Orders</h1>
        <div class="grid grid-cols-3 gap-2">
        <?php while($order = $preparingOrders->fetch_assoc()): ?>
            <div class="rounded-lg border bg-gray-200 flex flex-col items-center justify-center p-4">
                <p class="font-bold">Order #<?= $order['Order_id'] ?></p>
                <p>Table #<?= $order['Table_id'] ?></p>
                <p>Total: ₱<?= number_format($order['Total_amount'],2) ?></p>
            </div>
        <?php endwhile; ?>
        </div>
    </div>

    <!-- ----------------- PREPARED ORDERS ----------------- -->
    <div class="flex-1 m-8 bg-gray-300 rounded-lg p-4 shadow-lg overflow-y-auto">
        <h1 class="font-bold text-center text-2xl pb-4 border-b mb-4">Prepared Orders</h1>
        <div class="grid grid-cols-3 gap-2">
        <?php while($order = $preparedOrders->fetch_assoc()): ?>
            <div class="rounded-lg border bg-gray-200 flex flex-col items-center justify-center p-4">
                <p class="font-bold">Order #<?= $order['Order_id'] ?></p>
                <p>Table #<?= $order['Table_number'] ?></p>
                <p>Total: ₱<?= number_format($order['Total_amount'],2) ?></p>
                <form method="POST" class="mt-2 flex flex-col gap-1 w-full">
                    <input type="hidden" name="order_id" value="<?= $order['Order_id'] ?>">
                    <input type="number" name="waiter_id" placeholder="Waiter ID" class="p-2 border rounded" required>
                    <button type="submit" name="delete_order" class="bg-red-600 text-white p-2 rounded hover:bg-red-500">
                        Mark as Served & Delete
                    </button>
                </form>
            </div>
        <?php endwhile; ?>
        </div>
    </div>
</div>
    <!-- ----------------- TABLE STATUS ----------------- -->
    <div class="flex-1 m-8 bg-gray-300 rounded-lg p-4 shadow-lg overflow-y-auto">
        <h1 class="font-bold text-center text-2xl pb-4 border-b mb-4">Tables</h1>
        <div class="flex flex-col gap-2">
        <?php while($table = $tables->fetch_assoc()): ?>
            <div class="rounded-lg border bg-gray-200 flex items-center justify-between p-4">
                <p class="font-bold">Table #<?= $table['Table_number'] ?></p>
                <form method="POST" class="flex gap-2 items-center">
                    <select name="table_status" class="p-2 border rounded" required>
                        <option value="Available" <?= $table['Table_status']=='Available'?'selected':'' ?>>Available</option>
                        <option value="Occupied" <?= $table['Table_status']=='Occupied'?'selected':'' ?>>Occupied</option>
                        <option value="Dirty" <?= $table['Table_status']=='Dirty'?'selected':'' ?>>Dirty</option>
                    </select>
                    <input type="number" name="waiter_id" placeholder="Waiter ID" class="p-2 border rounded" required>
                    <input type="hidden" name="table_id" value="<?= $table['Table_id'] ?>">
                    <button type="submit" name="update_table_status" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-500">
                        Update
                    </button>
                </form>
            </div>
        <?php endwhile; ?>
        </div>
    </div>
</section>
<?php require '../footer.php'; ?>