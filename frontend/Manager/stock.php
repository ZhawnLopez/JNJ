<?php require '../header.php' 
//check ingredient stock statuses, ask for supply
?>
    <p>Ingredients Stock</p>
</nav>

<section class="min-h-screen flex flex-1 overflow-hidden">
    
    <div class="w-1/5 p-6 overflow-y-auto flex flex-col gap-4 bg-gray-700 text-white font-bold *:shadow-lg *:rounded-lg *:duration-200 *:p-2 *:py-4 *:hover:bg-gray-600">
        <a href="stock.php">Stock</a>
        <a href="employees.php">Employees</a>
    </div>

     <div class="flex-1 m-8 bg-gray-300 rounded-lg p-4 flex flex-col shadow-lg gap-4 overflow-y-auto px-10">
        
        <h2 class="text-5xl font-bold m-2 mb-4">List of Ingredients</h2>
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
                    <th>Status Updated</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white *:p-2 text-center">
                    <td>1</td>
                    <td>Tomatoes</td>
                    <td>Vegetables</td>
                    <td>50</td>
                    <td>Kg</td>
                    <td>2026-02-10</td>
                    <td>2026-02-25</td>
                    <td class="restock-status">Need Restock</td>
                    <td>2026-02-18 10:30:00</td>
                    <td>Chef Kofu</td>
                    <td>
                        <button class="requestSupplyBtn bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-500" 
                            data-ingredient="Tomatoes" data-unit="Kg">
                            Request Supply
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ---requesting stock from supply table --->
    <div id="supplyModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg w-96 p-6 shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Request Supply</h2>
        <form id="supplyForm" class="space-y-3">
        <input type="hidden" name="ingredient_name" id="ingredientNameInput">

        <p id="ingredientLabel" class="font-semibold"></p>

        <input type="number" name="quantity" placeholder="Quantity Needed" class="w-full p-2 rounded border border-gray-400" required>
        <input type="text" name="unit" placeholder="Unit (Kg, L, etc.)" class="w-full p-2 rounded border border-gray-400" required>
        <input type="text" name="supplier" placeholder="Supplier Name" class="w-full p-2 rounded border border-gray-400" required>

        <div class="flex justify-end gap-2 mt-4">
            <button type="button" id="cancelSupplyBtn" class="px-4 py-2 rounded bg-gray-400 text-white hover:bg-gray-500">Cancel</button>
            <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-500">Request</button>
        </div>
        </form>
    </div>
    </div>

</section>
<script>
  const supplyModal = document.getElementById('supplyModal');
  const cancelSupplyBtn = document.getElementById('cancelSupplyBtn');
  const supplyForm = document.getElementById('supplyForm');
  const ingredientLabel = document.getElementById('ingredientLabel');
  const ingredientInput = document.getElementById('ingredientNameInput');

  document.querySelectorAll('.requestSupplyBtn').forEach(btn => {
    btn.addEventListener('click', () => {
      const ingredient = btn.dataset.ingredient;
      const unit = btn.dataset.unit;
      ingredientLabel.textContent = `Request supply for: ${ingredient}`;
      ingredientInput.value = ingredient;
      supplyModal.classList.remove('hidden');
    });
  });

  // Cancel button closes modal
  cancelSupplyBtn.addEventListener('click', () => {
    supplyModal.classList.add('hidden');
    supplyForm.reset();
  });

  // Handle form submission
  supplyForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(supplyForm);
    console.log('Request Submitted:', Object.fromEntries(formData.entries()));

    supplyModal.classList.add('hidden');
    supplyForm.reset();
  });
</script>

<?php require '../footer.php' ?>