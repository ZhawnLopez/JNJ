<?php 
require '../../backend/stockint.php';
?>
<p>Ingredient List</p>
</nav>
<section class="min-h-screen flex flex-1 overflow-hidden">

    <div class="w-1/5 p-6 overflow-y-auto flex flex-col gap-4 bg-gray-700 text-white font-bold *:shadow-lg *:rounded-lg *:duration-200 *:p-2 *:py-4 *:hover:bg-gray-600">
        <a href="menu.php">Menu</a>    
        <a href="stock.php">Stock</a>
        <a href="employees.php">Employees</a>
    </div>

    <div class="flex-1 m-8 bg-gray-300 rounded-lg p-4 flex flex-col shadow-lg gap-4 overflow-y-auto px-10">
        <div class="flex justify-between items-center">
            <h1 class="text-5xl font-bold m-2">Ingredients</h1>
            <button id="openIngredientModal" class="rounded-lg bg-green-600 text-white font-semibold p-2 px-4">Add Ingredient</button>
        </div>

        <table class="table-fixed w-full border-collapse bg-white">
            <thead>
                <tr class="bg-gray-100 *:p-2">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Date Received</th>
                    <th>Expiry Date</th>
                    <th>Restock Status</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php while($ing = $ingredients->fetch_assoc()): ?>
                <tr class="text-center *:p-2 text-center">
                    <td><?= $ing['Ingredients_id'] ?></td>
                    <td><?= htmlspecialchars($ing['Ingredients_name']) ?></td>
                    <td><?= htmlspecialchars($ing['Category']) ?></td>
                    <td><?= $ing['Quantity_available'] ?></td>
                    <td><?= htmlspecialchars($ing['Unit_of_measure']) ?></td>
                    <td><?= $ing['Date_received'] ?></td>
                    <td><?= $ing['Expiry_date'] ?></td>
                    <td><?= htmlspecialchars($ing['Restock_status']) ?></td>
                    <td><?= htmlspecialchars($ing['Chef_name']) ?></td>
                    <td>
                        <button class="editIngredientBtn bg-gray-200 px-2 py-1 rounded" 
                            data-id="<?= $ing['Ingredients_id'] ?>"
                            data-name="<?= htmlspecialchars($ing['Ingredients_name']) ?>"
                            data-category="<?= htmlspecialchars($ing['Category']) ?>"
                            data-quantity="<?= $ing['Quantity_available'] ?>"
                            data-unit="<?= htmlspecialchars($ing['Unit_of_measure']) ?>"
                            data-date_received="<?= $ing['Date_received'] ?>"
                            data-expiry="<?= $ing['Expiry_date'] ?>"
                            data-restock="<?= htmlspecialchars($ing['Restock_status']) ?>"
                            data-chef="<?= $ing['Chef_id'] ?>">
                            Edit
                        </button>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this ingredient?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="ingredient_id" value="<?= $ing['Ingredients_id'] ?>">
                            <button type="submit" class="text-red-600 font-bold">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal for Add/Edit Ingredient -->
<div id="ingredientModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg w-1/2 p-6 shadow-lg max-h-[90vh] overflow-y-auto">
        <h2 class="text-2xl font-bold mb-4" id="ingredientModalTitle">Add Ingredient</h2>
        <form id="ingredientForm" method="POST" class="space-y-3">
            <input type="hidden" name="action" value="add" id="ingredientFormAction">
            <input type="hidden" name="ingredient_id" id="ingredientOriginalId">
            <input type="text" name="ingredient_name" placeholder="Ingredient Name" class="w-full p-2 border rounded" required>
            <input type="text" name="category" placeholder="Category" class="w-full p-2 border rounded" required>
            <input type="number" name="quantity" placeholder="Quantity Available" class="w-full p-2 border rounded" min="0" required>
            <input type="text" name="unit" placeholder="Unit of Measure" class="w-full p-2 border rounded">
            <input type="date" name="date_received" class="w-full p-2 border rounded">
            <input type="date" name="expiry_date" class="w-full p-2 border rounded" required>
            <select name="restock_status" class="w-full p-2 border rounded">
                <option value="Good">Good</option>
                <option value="Need Restock">Need Restock</option>
            </select>
            <input type="number" name="chef_id" placeholder="Chef ID" class="w-full p-2 border rounded" required>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="cancelIngredientBtn" class="px-4 py-2 rounded bg-gray-400 text-white hover:bg-gray-500">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-500">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
const ingredientModal = document.getElementById('ingredientModal');
const openIngredientBtn = document.getElementById('openIngredientModal');
const cancelIngredientBtn = document.getElementById('cancelIngredientBtn');
const ingredientForm = document.getElementById('ingredientForm');

openIngredientBtn.addEventListener('click', () => {
    ingredientModal.classList.remove('hidden');
    document.getElementById('ingredientFormAction').value = 'add';
    document.getElementById('ingredientModalTitle').textContent = 'Add Ingredient';
    ingredientForm.reset();
});

// Cancel button
cancelIngredientBtn.addEventListener('click', () => {
    ingredientModal.classList.add('hidden');
    ingredientForm.reset();
});

// Edit buttons
document.querySelectorAll('.editIngredientBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        ingredientModal.classList.remove('hidden');
        document.getElementById('ingredientFormAction').value = 'edit';
        document.getElementById('ingredientModalTitle').textContent = 'Edit Ingredient';
        document.getElementById('ingredientOriginalId').value = btn.dataset.id;

        // Fill form
        const fields = ['ingredient_name','category','quantity','unit','date_received','expiry_date','restock_status','chef_id'];
        const mapping = {
            ingredient_name: btn.dataset.name,
            category: btn.dataset.category,
            quantity: btn.dataset.quantity,
            unit: btn.dataset.unit,
            date_received: btn.dataset.date_received,
            expiry_date: btn.dataset.expiry,
            restock_status: btn.dataset.restock,
            chef_id: btn.dataset.chef
        };
        fields.forEach(f => {
            const input = ingredientForm.querySelector(`[name="${f}"]`);
            if(input) input.value = mapping[f] || '';
        });
    });
});
</script>
