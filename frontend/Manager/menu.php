<?php
require '../../backend/menuint.php';
?>
    <p>Menu</p>
</nav>

<section class="min-h-screen flex flex-1 overflow-hidden">
    
    <div class="w-1/5 p-6 overflow-y-auto flex flex-col gap-4 bg-gray-700 text-white font-bold *:shadow-lg *:rounded-lg *:duration-200 *:p-2 *:py-4 *:hover:bg-gray-600">
        <a href="menu.php">Menu</a>    
        <a href="stock.php">Stock</a>
        <a href="employees.php">Employees</a>
    </div>

     <div class="flex-1 m-8 bg-gray-300 rounded-lg p-4 flex flex-col shadow-lg gap-4 overflow-y-auto px-10">
        
        <div class="flex justify-between items-center">
            <h1 class="text-5xl font-bold m-2">Menu List</h1>
            <button id="openMenuModal" class="rounded-lg bg-green-600 text-white font-semibold p-2 px-4">Add Dish</button>
        </div>
        <table class="table-fixed w-full border-collapse bg-white">
            <thead>
                <tr class="bg-gray-100 *:p-2">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Prep Time (min)</th>
                    <th>Status</th>
                    <th>Ingredients</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                 <?php while($d = $dishes->fetch_assoc()): ?>
                <tr class="bg-white *:p-2 text-center">
                    <td><?= $d['Dish_id'] ?></td>
                    <td><?= htmlspecialchars($d['Dish_name']) ?></td>
                    <td><?= $d['Dish_category'] ?></td>
                    <td><?= number_format($d['Price'],2) ?></td>
                    <td><?= $d['Preparation_timeMin'] ?></td>
                    <td><?= $d['Availability_status'] ?></td>
                    <td><?= htmlspecialchars($d['Ingredients']) ?></td>
                    <td>
                        <button class="editBtn px-2 m-0.5 rounded bg-gray-200" 
                                data-id="<?= $d['Dish_id'] ?>"
                                data-name="<?= htmlspecialchars($d['Dish_name']) ?>"
                                data-category="<?= $d['Dish_category'] ?>"
                                data-price="<?= $d['Price'] ?>"
                                data-prep="<?= $d['Preparation_timeMin'] ?>"
                                data-status="<?= $d['Availability_status'] ?>"
                                data-ingredients="<?= htmlspecialchars($d['Ingredients']) ?>">
                            Edit
                        </button>
                        <form method="POST" style="display:inline" onsubmit="return confirm('Delete this dish?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="dish_id" value="<?= $d['Dish_id'] ?>">
                            <button type="submit" class="text-red-600 font-bold">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>
<div id="menuModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg w-1/2 p-6 shadow-lg max-h-[90vh] overflow-y-auto">
        <h2 class="text-2xl font-bold mb-4" id="modalTitle">Add New Dish</h2>
        <form id="menuForm" method="POST" class="space-y-3">
            <input type="hidden" name="action" value="add" id="formAction">
            <input type="hidden" name="dish_id" value="" id="dishId">

            <input type="text" name="dish_name" placeholder="Dish Name" class="w-full p-2 border rounded" required>
            <select name="dish_category" class="w-full p-2 border rounded" required>
                <option value="">Select Category</option>
                <option value="Main">Main</option>
                <option value="Soup">Soup</option>
                <option value="Sides">Sides</option>
                <option value="Appetizer">Appetizer</option>
            </select>
            <input type="number" name="price" placeholder="Price" step="0.01" class="w-full p-2 border rounded" required>
            <input type="number" name="prep_time" placeholder="Preparation Time (min)" class="w-full p-2 border rounded">
            <select name="availability_status" class="w-full p-2 border rounded" required>
                <option value="Available">Available</option>
                <option value="Unavailable">Unavailable</option>
            </select>
            <textarea name="ingredients" placeholder="Ingredients" class="w-full p-2 border rounded"></textarea>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="cancelBtn" class="px-4 py-2 rounded bg-gray-400 text-white hover:bg-gray-500">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-500">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
// Modal control
const modal = document.getElementById('menuModal');
const openBtn = document.getElementById('openMenuModal');
const cancelBtn = document.getElementById('cancelBtn');
const formActionInput = document.getElementById('formAction');
const modalTitle = document.getElementById('modalTitle');
const dishIdInput = document.getElementById('dishId');
const menuForm = document.getElementById('menuForm');

openBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
    formActionInput.value = 'add';
    modalTitle.textContent = 'Add New Dish';
    menuForm.reset();
    dishIdInput.value = '';
});

cancelBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
});

// Edit functionality
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        formActionInput.value = 'edit';
        modalTitle.textContent = 'Edit Dish';
        dishIdInput.value = btn.dataset.id;
        menuForm.elements['dish_name'].value = btn.dataset.name;
        menuForm.elements['dish_category'].value = btn.dataset.category;
        menuForm.elements['price'].value = btn.dataset.price;
        menuForm.elements['prep_time'].value = btn.dataset.prep;
        menuForm.elements['availability_status'].value = btn.dataset.status;
        menuForm.elements['ingredients'].value = btn.dataset.ingredients;
    });
});
</script>

<?php require '../footer.php' ?>