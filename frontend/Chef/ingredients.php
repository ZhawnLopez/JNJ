<?php require '../../backend/chefint.php';?>
    <p>Ingredients & Recipies</p>
</nav>
<section class="min-h-screen flex flex-1 overflow-hidden">
    <div class="w-1/5 p-6 overflow-y-auto flex flex-col gap-4 bg-gray-700 text-white font-bold *:shadow-lg *:rounded-lg *:duration-200 *:p-2 *:py-4 *:hover:bg-gray-600">
        <a href="ingredients.php">Ingredients</a>
        <a href="recipies.php">Recipies</a>
    </div>
    <div class="flex-1 m-8 bg-gray-300 rounded-lg p-6 shadow-lg overflow-auto">
        <h1 class="text-5xl font-bold m-2">Ingredients List</h1>
        <div class="*:font-light m-2 p-2">
            <p>To change quantity: input number and press <strong>Enter</strong></p>
            <p>To change restock status: select a status</p>
        </div>
    <!-- ----------pop up modal -------->
    <div id="chefModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
        <form method="POST" class="bg-white rounded-lg p-6 w-96 shadow-lg">
            <h3 class="text-lg font-bold mb-4">Enter Chef ID</h3>
            <input type="hidden" name="ingredient_id" id="ingredientIdInput">
            <input type="hidden" name="restock_status" id="restockStatusInput">
            <input type="hidden" name="quantity_available" id="quantityInputHidden">
            <input type="hidden" name="update_ingredient" value="1">
            <select name="chef_id" id="chefIdInput" class="border rounded w-full p-2 mb-4" required>
                <option value="">Your Chef ID</option>
                <?php while ($c = $chefs->fetch_assoc()):?>
                    <option value="<?= $c['Chef_id'] ?>"><?= $c['Chef_id'] ?></option>
                <?php endwhile;?>
            </select>
            <div class="flex justify-end gap-2">
                <button id="cancelBtn" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Submit</button>
            </div>
        </form>
    </div>

    <table class="table-fixed w-full border-collapse bg-white">
        <thead>
            <tr class="bg-gray-100 *:p-2">
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Quantity Available</th>
                <th>Unit of Measure</th>
                <th>Date Received</th>
                <th>Expiry Date</th>
                <th>Restock Status</th>
                <th>Status Updated</th>
                <th>Updated By</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($ingredients->num_rows > 0): ?>
            <?php while($i = $ingredients->fetch_assoc()): ?>
                <tr class="bg-white *:p-2 text-center">
                    <td><?= $i['Ingredients_id'] ?></td>
                    <td><?= htmlspecialchars($i['Ingredients_name']) ?></td>
                    <td><?= htmlspecialchars($i['Category']) ?></td>
                    <td><input type="number" class="rounded p-1 bg-gray-100 w-15 text-center quantity-input" value="<?= $i['Quantity_available'] ?>" data-id="<?= $i['Ingredients_id'] ?>"
                    data-current="<?= $i['Quantity_available'] ?>"></td>
                    <td><?= htmlspecialchars($i['Unit_of_measure']) ?></td>
                    <td><?= $i['Date_received'] ?></td>
                    <td><?= $i['Expiry_date'] ?></td>
                    <td>
                        <select name="restock_status" class="rounded p-1 bg-gray-100 restock-select" data-id="<?= $i['Ingredients_id'] ?>" data-previous="<?= $i['Restock_status'] ?>">
                            <option value="Good" <?= $i['Restock_status'] == 'Good' ? 'selected' : '' ?>>Good</option>
                            <option value="Need Restock" <?= $i['Restock_status'] == 'Need Restock' ? 'selected' : '' ?>>Need Restock</option>
                        </select>
                    </td>
                    <td><?= $i['Status_updated'] ?></td>
                    <td class="updatedBy"><?= htmlspecialchars($i['Chef_name']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="10" class="text-center">No ingredients found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</section>

<script>
    const modal = document.getElementById('chefModal');
    const selects = document.querySelectorAll('.restock-select');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const ingredientInput = document.getElementById('ingredientIdInput');
    const statusInput = document.getElementById('restockStatusInput');
    const cancelBtn = document.getElementById('cancelBtn');
    const quantityHidden = document.getElementById('quantityInputHidden');
    selects.forEach(select => {//restock status select
        select.addEventListener('focus', function() {
            this.dataset.previous = this.value;
        });
        select.addEventListener('change', function() {
            ingredientInput.value = this.dataset.id;
            statusInput.value = this.value;
            modal.classList.remove('hidden');
        });});
    quantityInputs.forEach(input => {//quantity input
         input.addEventListener('keydown', function(e) {
            if (e.key === "Enter") {
                e.preventDefault(); // stop form auto-submit
                // Only open if value actually changed
                if (this.value === this.dataset.current) {
                    return;
                }
                const row = this.closest('tr');
                const statusValue = row.querySelector('.restock-select').value;
                ingredientInput.value = this.dataset.id;
                statusInput.value = statusValue;
                quantityHidden.value = this.value;
                modal.classList.remove('hidden');
    }});});
    cancelBtn.addEventListener('click', function() {
        modal.classList.add('hidden');
    });
</script>
<?php $conn->close(); require '../footer.php';?>