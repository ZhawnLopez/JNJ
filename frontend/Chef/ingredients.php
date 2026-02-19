<?php require '../header.php' ?>
    <p>Ingredients & Recipies</p>
</nav>
<section class="min-h-screen flex flex-1 overflow-hidden">
    <div class="w-1/5 p-6 overflow-y-auto flex flex-col gap-4 bg-gray-700 text-white font-bold *:shadow-lg *:rounded-lg *:duration-200 *:p-2 *:py-4 *:hover:bg-gray-600">
        <a href="ingredients.php">Ingredients</a>
        <a href="recipies.php">Recipies</a>
    </div>
    <div class="flex-1 m-8 bg-gray-300 rounded-lg p-6 shadow-lg border border-dashed overflow-auto">

    <h2 class="text-xl font-bold mb-4">Ingredients List</h2>

    <!-- ----------pop up modal -------->
    <div id="chefModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
        <h3 class="text-lg font-bold mb-4">Enter Chef ID</h3>
        <input type="text" id="chefIdInput" class="border rounded w-full p-2 mb-4" placeholder="Chef ID">
        <div class="flex justify-end gap-2">
        <button id="cancelBtn" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</button>
        <button id="submitBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Submit</button>
        </div>
    </div>
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
            <tr class="bg-white *:p-2 text-center">
                <td>1</td>
                <td>Tomatoes</td>
                <td>Vegetables</td>
                <td>50</td>
                <td>Kg</td>
                <td>2026-02-10</td>
                <td>2026-02-25</td>
                <td>
                    <select name="restock_status" class="rounded p-1 bg-gray-100 restock-select">
                        <option value="Good" selected>Good</option>
                        <option value="Need Restock">Need Restock</option>
                    </select>
                </td>
                <td>2026-02-18 10:30:00</td>
                <td class="updatedBy">Chef Kofu</td>
            </tr>
        </tbody>
    </table>
</div>
</section>

<script>
  const modal = document.getElementById('chefModal');
  const chefInput = document.getElementById('chefIdInput');
  const cancelBtn = document.getElementById('cancelBtn');
  const submitBtn = document.getElementById('submitBtn');
  const selects = document.querySelectorAll('.restock-select');

  selects.forEach(select => {
    select.addEventListener('change', (e) => {
      modal.classList.remove('hidden');
      chefInput.value = '';
      chefInput.focus();

      submitBtn.onclick = () => {
        const chefId = chefInput.value.trim();
        if(chefId === '') {
          alert('Please enter Chef ID!');
          return;
        }
        // Update the "Updated By" cell in the same row
        const row = select.closest('tr');
        row.querySelector('.updatedBy').textContent = chefId;

        modal.classList.add('hidden');
      };

      cancelBtn.onclick = () => {
        // Reset dropdown to previous value
        select.value = select.dataset.previous || 'Good';
        modal.classList.add('hidden');
      };

      // Store previous value in data attribute
      select.dataset.previous = select.value;
    });
  });
</script>
<?php require '../footer.php'?>
