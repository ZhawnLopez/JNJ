<?php require '../../backend/waiterint.php'; ?>
<p>Orders & Tables</p>
</nav>

<?php if(!empty($message)): ?>
    <div id="notification" class="fixed top-5 right-5 bg-white border-l-8 border-green-500 p-4 rounded-lg shadow-2xl z-[100] transition-opacity duration-500">
        <div class="flex items-center gap-3">
            <div class="bg-green-100 p-1 rounded-full">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <p class="font-bold text-gray-800"><?= htmlspecialchars($message) ?></p>
        </div>
    </div>
    <?php unset($_SESSION['message']); ?>
    <script>
        setTimeout(() => {
            const notif = document.getElementById('notification');
            if (notif) {
                notif.style.opacity = '0';
                setTimeout(() => notif.remove(), 500);
            }
        }, 3000);
    </script>
<?php endif; ?>

<section class="flex h-screen w-full bg-gray-100 overflow-hidden">
    <div class="w-1/2 flex flex-col border-r border-gray-300 p-4 gap-4 overflow-y-auto">
        <div class="flex-1 bg-gray-300 rounded-xl shadow-md p-4">
            <h2 class="text-xl font-bold flex items-center gap-2 mb-6 border-b pb-2">Preparing Orders</h2>
            <div class="grid grid-cols-2 gap-3">
                <?php while($order = $preparingOrders->fetch_assoc()): ?>
                    <div class="p-3 bg-white border rounded-lg shadow-sm">
                        <div class="flex justify-between items-start">
                            <span class="font-bold text-lg">#<?= $order['Order_id'] ?></span>
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded animate-pulse">Preparing</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">Table: <span class="font-semibold text-gray-800"><?= $order['Table_id'] ?></span></p>
                        <p class="text-sm text-gray-600 italic mt-1"><?= $order['Order_items'] ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="flex-1 bg-gray-300 rounded-xl shadow-md p-4">
            <h2 class="text-xl font-bold flex items-center gap-2 mb-6 border-b pb-2">Prepared Orders (Ready)</h2>
            <div class="grid grid-cols-2 gap-3">
                <?php while($order = $preparedOrders->fetch_assoc()): ?>
                    <button type="button" 
                            onclick="openServeModal(<?= $order['Order_id'] ?>)"
                            class="p-3 bg-green-50 border border-green-200 rounded-lg shadow-sm hover:bg-green-100 transition-all text-left group">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-lg text-green-700">#<?= $order['Order_id'] ?></span>
                            <span class="text-xs text-green-600 group-hover:underline font-bold">SERVE</span>
                        </div>
                        <p class="text-sm text-gray-600">Table: <span class="font-semibold text-gray-900"><?= $order['Table_id'] ?></span></p>
                    </button>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <div class="w-1/2 p-4 bg-gray-100 overflow-y-auto">
        <div class="bg-gray-300 rounded-xl shadow-md p-6 h-full">
            <h2 class="text-xl font-bold mb-6 border-b pb-2">Table Management</h2>
            <div class="grid grid-cols-2 gap-4">
                <?php while($table = $tables->fetch_assoc()): 
                    $statusColor = $table['Table_status'] == 'Available' ? 'bg-green-500' : ($table['Table_status'] == 'Occupied' ? 'bg-red-500' : 'bg-yellow-600');
                ?>
                    <div class="p-4 border rounded-xl flex flex-col gap-3 shadow-sm bg-white">
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-black ">T-<?= $table['Table_id'] ?></span>
                            <div class="h-4 w-4 rounded-full <?= $statusColor ?> shadow-sm"></div>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-bold">Status</p>
                            <select onchange="openStatusModal(<?= $table['Table_id'] ?>, this.value)" 
                                    class="w-full mt-1 p-2 border rounded-md bg-gray-50 font-semibold focus:ring-2 focus:ring-blue-500">
                                <option value="Available" <?= $table['Table_status']=='Available'?'selected':'' ?>>Available</option>
                                <option value="Occupied" <?= $table['Table_status']=='Occupied'?'selected':'' ?>>Occupied</option>
                                <option value="Dirty" <?= $table['Table_status']=='Dirty'?'selected':'' ?>>Dirty</option>
                            </select>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>

<div id="waiterModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl shadow-2xl w-80">
        <h3 class="text-lg font-bold mb-4 text-center text-gray-700">Update Table Status</h3>
        <form method="POST">
            <input type="hidden" name="table_id" id="modalTableId">
            <input type="hidden" name="table_status" id="modalTableStatus">
            <select name="waiter_id" required class="w-full p-3 border rounded-lg mb-4 text-center font-bold">
                <option value="" disabled selected>Select Waiter ID</option>
                <?php $waiterList->data_seek(0); while($w = $waiterList->fetch_assoc()): ?>
                    <option value="<?= $w['Waiter_id'] ?>">ID: <?= $w['Waiter_id'] ?></option>
                <?php endwhile; ?>
            </select>
            <div class="flex gap-2">
                <button type="button" onclick="closeModal('waiterModal')" class="flex-1 py-2 bg-gray-200 rounded-lg">Cancel</button>
                <button type="submit" name="update_table_status" class="flex-1 py-2 bg-blue-600 text-white rounded-lg font-bold">Update</button>
            </div>
        </form>
    </div>
</div>

<div id="serveModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl shadow-2xl w-80">
        <h3 class="text-lg font-bold mb-2 text-center text-gray-700">Confirm Serving</h3>
        <p class="text-center text-sm text-gray-500 mb-4 font-bold">Order #<span id="serveOrderIdDisplay"></span></p>
        <form method="POST">
            <input type="hidden" name="order_id" id="serveOrderIdInput">
            <select name="waiter_id" required class="w-full p-3 border rounded-lg mb-4 text-center font-bold">
                <option value="" disabled selected>Select your ID</option>
                <?php $waiterList->data_seek(0); while($w = $waiterList->fetch_assoc()): ?>
                    <option value="<?= $w['Waiter_id'] ?>"><?= $w['Waiter_id'] ?></option>
                <?php endwhile; ?>
            </select>
            <div class="flex gap-2">
                <button type="button" onclick="closeModal('serveModal')" class="flex-1 py-2 bg-gray-200 rounded-lg">Cancel</button>
                <button type="submit" name="delete_order" class="flex-1 py-2 bg-green-600 text-white rounded-lg font-bold">Complete</button>
            </div>
        </form>
    </div>
</div>

<script>
function openStatusModal(tableId, status) {
    document.getElementById('modalTableId').value = tableId;
    document.getElementById('modalTableStatus').value = status;
    document.getElementById('waiterModal').classList.remove('hidden');
}

function openServeModal(orderId) {
    document.getElementById('serveOrderIdDisplay').textContent = orderId;
    document.getElementById('serveOrderIdInput').value = orderId;
    document.getElementById('serveModal').classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    if(modalId === 'waiterModal') location.reload(); // Reset select if canceled
}
</script>