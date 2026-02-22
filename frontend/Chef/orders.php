
<?php require '../../backend/chefint.php';
//displays new orders, and currently preparing orders (orders that are taken by other chefs already)
?>
    <p>Orders</p>
</nav>
<section class="min-h-screen flex flex-1 overflow-hidden">
    <div class="flex-1 m-8 mr-0 bg-gray-300 rounded-lg p-4 shadow-lg overflow-y-auto">
       <h1 class="font-bold text-center text-2xl pb-4 border-b">New Orders</h1>
       <div class="grid grid-cols-3 overflow-y-auto">
        <?php while($row = $newOrders->fetch_assoc()): ?>
            <div onclick="openAcceptModal(<?= $row['Order_id'] ?>)" class="cursor-pointer rounded-lg border bg-gray-200 flex flex-col items-center justify-center m-2 p-2">
                <p class="font-bold p-2 text-lg">Order#<?= $row['Order_id'] ?></p>
                <div class="w-full flex flex-col">
                    <?php 
                        $items = explode(", ", $row['Order_items']);
                        foreach($items as $item): ?>
                            <p class="text-sm py-1"><?= htmlspecialchars($item) ?></p>
                    <?php endforeach; ?>
                    <span class="mt-2 text-xs text-gray-400"><?= date('h:i A', strtotime($row['Order_date'])) ?></span>
                </div>
               
            </div>  
             <?php endwhile; ?>  
        </div>
    </div>
    <div class="flex-1 m-8 mr-0 bg-gray-300 rounded-lg p-4 shadow-lg overflow-y-auto">
        <div class="flex flex-col">
            <h1 class="font-bold text-center text-2xl pb-4 border-b">Preparing Orders</h1>
            <div class="grid grid-cols-3 overflow-y-auto">
                <?php while($row = $preparingOrders->fetch_assoc()): ?>
                <div class="rounded-lg border bg-gray-200 flex flex-col items-center justify-center m-2 p-2">
                    <p class="font-bold p-2 text-lg">Order#<?= $row['Order_id'] ?></p>
                    <div class="pb-2 border-b w-full flex flex-col">
                        <?php 
                            $items = explode(", ", $row['Order_items']);
                            foreach($items as $item): ?>
                                <p class="text-sm border-b border-blue-100 py-1"><?= htmlspecialchars($item) ?></p>
                        <?php endforeach; ?>
                    </div>
                    <p>Chef:<?= htmlspecialchars($row['Chef_name']) ?></p>
                </div>   
                <?php endwhile; ?> 
            </div>
        </div>
    </div>
    
    <!--accept order modal-->
    <div id="acceptModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
        <form method="POST" class="bg-white rounded-lg p-8 w-96 shadow-2xl">
            <h2 class="text-xl font-bold mb-4">Accept Order #<span id="modalOrderIdLabel"></span></h2>
            <input type="hidden" name="order_id" id="modalOrderIdInput">
            <label class="block mb-2 font-semibold">Select Available Chef:</label>
            <select name="chef_id" class="w-full p-2 border rounded mb-6" required>
                <option value="">-- Select Chef --</option>
                <?php if ($availableChefs && $availableChefs->num_rows > 0): ?>
                    <?php while($c = $availableChefs->fetch_assoc()): ?>
                        <option value="<?= $c['Chef_id'] ?>">
                            <?= $c['Chef_id'] ?> - <?= htmlspecialchars($c['Chef_name']) ?>
                        </option>
                    <?php endwhile; ?>
                <?php else: ?>
                    <option value="" disabled>No chefs available</option>
                <?php endif; ?>
            </select>
            <div class="flex gap-4">
                <button type="button" onclick="closeModal()" class="flex-1 bg-gray-400 text-white py-2 rounded">Cancel</button>
                <button type="submit" name="take_order" class="flex-1 bg-green-600 text-white py-2 rounded font-bold">Start Cooking</button>
            </div>
        </form>
    </div>
</section>
<script>
    const modal = document.getElementById('acceptModal');
    const orderIdLabel = document.getElementById('modalOrderIdLabel');
    const orderIdInput = document.getElementById('modalOrderIdInput');

    function openAcceptModal(orderId) {
        orderIdLabel.textContent = orderId;
        orderIdInput.value = orderId;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    // Close modal if user clicks outside of the white box
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
<?php require '../footer.php'?>
