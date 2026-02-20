
<?php
require '../../backend/waiterint.php';
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