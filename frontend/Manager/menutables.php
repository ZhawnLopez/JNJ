<?php
require '../../backend/menutablesint.php';
?>
    <p>Menu & Tables</p>
</nav>

<section class="min-h-screen flex flex-1 overflow-hidden">
    <div class="w-1/5 p-6 overflow-y-auto flex flex-col gap-4 bg-gray-700 text-white font-bold *:shadow-lg *:rounded-lg *:duration-200 *:p-2 *:py-4 *:hover:bg-gray-600">
        <a href="menutables.php">Menu & Tables</a>    
        <a href="stock.php">Stock</a>
        <a href="employees.php">Employees</a>
    </div>
    <div class="flex-1 flex-col">
    <div class="flex-1 m-8 bg-gray-300 rounded-lg p-4 flex flex-col shadow-lg gap-4 overflow-y-auto px-10">
        <div class="flex justify-between items-center">
            <h1 class="text-5xl font-bold m-2">Menu List</h1>
            <button id="openMenuModal" class="rounded-lg bg-green-600 text-white font-semibold p-2 px-4 hover:bg-green-700 hover:shadow-md duration-200">Add Dish</button>
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
                        <button class="editMenuBtn px-2 m-0.5 rounded bg-gray-200" 
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
                            <input type="hidden" name="action" value="deleteDish">
                            <input type="hidden" name="dish_id" value="<?= $d['Dish_id'] ?>">
                            <button type="submit" class="text-red-600 font-bold">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <div class="flex-1 m-8 bg-gray-300 rounded-lg p-4 flex flex-col shadow-lg gap-4 overflow-y-auto px-10">
        <div class="flex justify-between items-center">
            <h1 class="text-5xl font-bold m-2">Tables</h1>
            <button id="openTableModal" class="rounded-lg bg-green-600 text-white font-semibold p-2 px-4 hover:bg-green-700 hover:shadow-md duration-200">Add Table</button>
        </div>
        <table class="table-fixed w-full border-collapse bg-white">
            <thead>
                <tr class="bg-gray-100 *:p-2">
                    <th>ID</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Latest Update By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                 <?php while($t = $tables->fetch_assoc()): ?>
                <tr class="bg-white *:p-2 text-center">
                    <td><?= $t['Table_id'] ?></td>
                    <td><?= $t['Table_capacity'] ?></td>
                    <td><?= $t['Table_status'] ?></td>
                    <td><?= $t['Waiter_name'] ?></td>
                    <td>
                        <button class="editTableBtn px-2 m-0.5 rounded bg-gray-200" 
                                data-id="<?= $t['Table_id'] ?>"
                                data-capacity="<?= $t['Table_capacity'] ?>"
                                data-status="<?= $t['Table_status'] ?>"
                                data-waiter="<?= $t['Waiter_id'] ?>">
                            Edit
                        </button>
                        <form method="POST" style="display:inline" onsubmit="return confirm('Delete this Table?');">
                            <input type="hidden" name="action" value="deleteTable">
                            <input type="hidden" name="table_id" value="<?= $t['Table_id'] ?>">
                            <button type="submit" class="text-red-600 font-bold">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    </div>
</section>

<!--- MODALS 
---------------MENU MODAL --->
<div id="menuModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg w-1/2 p-6 shadow-lg max-h-[90vh] overflow-y-auto">
        <h2 class="text-2xl font-bold mb-4" id="modalMenuTitle">Add New Dish</h2>
        <form id="menuForm" method="POST" class="space-y-3">
            <input type="hidden" name="action" value="addDish" id="formMenuAction">
            <input type="hidden" name="dish_id" value="" id="dishId">
            <div class="flex gap-2 items-center *:w-full">
                <div>
                    <label for="dish_name">Dish Name</label>
                    <input type="text" name="dish_name" placeholder="Food.." class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label for="dish_category">Category</label>
                    <select name="dish_category" class="w-full p-2 border rounded" required>
                        <option value="">Select Category</option>
                        <option value="Main">Main</option>
                        <option value="Soup">Soup</option>
                        <option value="Sides">Sides</option>
                        <option value="Appetizer">Appetizer</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-2 items-center *:w-full">
                <div>
                    <label for="price">Set Price</label>
                    <input type="number" name="price" placeholder="100.00" step="0.01" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label for="prep_time">Prep Time in Minutes</label>
                    <input type="number" name="prep_time" placeholder="5" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="availability_status">Set Availability</label>
                    <select name="availability_status" class="w-full p-2 border rounded" required>
                        <option value="Available">Available</option>
                        <option value="Unavailable">Unavailable</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-2 items-center *:w-full">
                <div>
                    <label for="ingredients">List Ingredients</label>
                    <textarea name="ingredients" placeholder="salt, pepper, olive oil..." class="w-full p-2 border rounded"></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="cancelMenuBtn" class="px-4 py-2 rounded bg-gray-400 text-white hover:bg-gray-500">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-500">Save</button>
            </div>
        </form>
    </div>
</div>
<!----------TABLE MODAL----->
<div id="tableModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg w-1/2 p-6 shadow-lg max-h-[90vh] overflow-y-auto">
        <h2 class="text-2xl font-bold mb-4" id="modalTableTitle">Add New Dish</h2>
        <form id="tableForm" method="POST" class="space-y-3">
            <input type="hidden" name="action" value="addTable" id="formTableAction">
            <input type="hidden" name="table_id" value="" id="tableId">
            <div class="flex gap-2 items-center *:w-full">
                <div id="editTableId" class="hidden">
                    <label for="tableIdDisplay">Table ID</label>
                    <input type="text" id="tableIdDisplay" class="w-full p-2 border rounded" disabled>
                </div>
                <div>
                    <label for="table_capacity">Table_Capacity</label>
                    <input name="table_capacity" class="w-full p-2 border rounded" placeholder="4" required>
                </div>
            </div>
            <div class="flex gap-2 items-center *:w-full">
                <div>
                    <label for="table_status">Table Status</label>
                    <select name="table_status" class="w-full p-2 border rounded">
                        <option value="">Select Status</option>
                        <option value="Dirty">Dirty</option>
                        <option value="Available">Available</option>
                        <option value="Occupied">Occupied</option>
                    </select>
                </div>
                <div>
                    <label for="waiter_id">Updated by</label>
                    <select name="waiter_id" class="w-full p-2 border rounded">
                        <option value="">Select Waiter</option>
                        <?php while($w = $waiters->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($w['Waiter_id']) ?>"><?= htmlspecialchars($w['Waiter_name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="cancelTableBtn" class="px-4 py-2 rounded bg-gray-400 text-white hover:bg-gray-500">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-500">Save</button>
            </div>
        </form>
    </div>
</div>

<script>

// Modal control
const menuModal = document.getElementById('menuModal');
const openMenuModal = document.getElementById('openMenuModal');
const cancelMenuBtn = document.getElementById('cancelMenuBtn');
const formMenuActionInput = document.getElementById('formMenuAction');
const modalMenuTitle = document.getElementById('modalMenuTitle');
const dishIdInput = document.getElementById('dishId');
const menuForm = document.getElementById('menuForm');

openMenuModal.addEventListener('click', () => {
    menuModal.classList.remove('hidden');
    formMenuActionInput.value = 'addDish';
    modalMenuTitle.textContent = 'Add New Dish';
    menuForm.reset();
    dishIdInput.value = '';
});

cancelMenuBtn.addEventListener('click', () => {
    menuModal.classList.add('hidden');
});

// Edit functionality
document.querySelectorAll('.editMenuBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        menuModal.classList.remove('hidden');
        formMenuActionInput.value = 'editDish';
        modalMenuTitle.textContent = 'Edit Dish';
        dishIdInput.value = btn.dataset.id;
        menuForm.elements['dish_name'].value = btn.dataset.name;
        menuForm.elements['dish_category'].value = btn.dataset.category;
        menuForm.elements['price'].value = btn.dataset.price;
        menuForm.elements['prep_time'].value = btn.dataset.prep;
        menuForm.elements['availability_status'].value = btn.dataset.status;
        menuForm.elements['ingredients'].value = btn.dataset.ingredients;
    });
});



//--------TABLE MODAL STUFF----------------
const tableModal = document.getElementById('tableModal');
const openTableModal = document.getElementById('openTableModal');
const cancelTableBtn = document.getElementById('cancelTableBtn');
const formTableActionInput = document.getElementById('formTableAction');
const modalTableTitle = document.getElementById('modalTableTitle');
const tableIdInput = document.getElementById('tableId');
const tableForm = document.getElementById('tableForm');
const tableIdEdit = document.getElementById('editTableId');

openTableModal.addEventListener('click', () => {
    tableModal.classList.remove('hidden');
    formTableActionInput.value = 'addTable';
    modalTableTitle.textContent = 'Add New Table';
    tableForm.reset();
    tableIdInput.value = '';
    document.getElementById('tableIdDisplay').value = '';
    tableIdEdit.classList.add('hidden');
    tableIdInput.value = '';
});

cancelTableBtn.addEventListener('click', () => {
    tableModal.classList.add('hidden');
});

document.querySelectorAll('.editTableBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        tableModal.classList.remove('hidden');
        formTableActionInput.value = 'editTable';
        modalTableTitle.textContent = 'Edit Table';
        const id = btn.dataset.id;
        tableIdInput.value = id;
        document.getElementById('tableIdDisplay').value = id;
        tableIdEdit.classList.remove('hidden');
        tableForm.elements['table_capacity'].value = btn.dataset.capacity;
        tableForm.elements['table_status'].value = btn.dataset.status;
        tableForm.elements['waiter_id'].value = btn.dataset.waiter;

    });
});
</script>

<?php require '../footer.php' ?>