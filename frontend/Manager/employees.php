<?php require '../header.php'
//list of employees, cashiers, chefs, waiters, can register them through here and set passcode?>
    <p>Employee List</p>
</nav>
<section class="min-h-screen flex flex-1 overflow-hidden">
    <div class="w-1/5 p-6 overflow-y-auto flex flex-col gap-4 bg-gray-700 text-white font-bold *:shadow-lg *:rounded-lg *:duration-200 *:p-2 *:py-4 *:hover:bg-gray-600">
        <a href="stock.php">Stock</a>
        <a href="employees.php">Employees</a>
    </div>
    
    <div class="flex-1 m-8 bg-gray-300 rounded-lg p-4 flex flex-col shadow-lg gap-4 overflow-y-auto px-10">
        <div class="flex justify-between items-center">
            <h1 class="text-5xl font-bold m-2">Employees</h1>
            <button id="openEmployeeModal" class="rounded-lg bg-green-600 text-white font-semibold p-2 px-4">Register an Employee</button>
        </div>
        <p class="font-semibold text-center pb-2 border-b">Cashiers</p>
        <table class="table-fixed w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 *:p-2">
                    <th>Cashier ID</th>
                    <th>Cashier Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Shift</th>
                    <th>Date Hired</th>
                    <th>Total Transactions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white *:p-2 text-center">
                    <td>001</td>
                    <td>John Doe</td>
                    <td>john@email.com</td>
                    <td>123-456-7890</td>
                    <td>Morning</td>
                    <td>2023-01-10</td>
                    <td>154</td>
                </tr>
            </tbody>
        </table>

        <p class="font-semibold text-center pb-2 border-b">Waiters</p>
        <table class="table-fixed w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 *:p-2">
                    <th>Waiter ID</th>
                    <th>Waiter Name</th>
                    <th>Contact Number</th>
                    <th>Shift</th>
                    <th>Assigned Section</th>
                    <th>Date Hired</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white *:p-2 text-center">
                    <td>1</td>
                    <td>Maria Santos</td>
                    <td>09123456789</td>
                    <td>Morning</td>
                    <td>Section A</td>
                    <td>2024-03-15</td>
                </tr>
            </tbody>
        </table>

        <p class="font-semibold text-center pb-2 border-b">Chefs</p>
        <table class="table-fixed w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 *:p-2">
                    <th>Chef ID</th>
                    <th>Chef Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Speciality</th>
                    <th>Shift</th>
                    <th>Years of Experience</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white *:p-2 text-center">
                    <td>101</td>
                    <td>John Rivera</td>
                    <td>chef@email.com</td>
                    <td>09987654321</td>
                    <td>Italian Cuisine</td>
                    <td>Evening</td>
                    <td>8</td>
                </tr>
            </tbody>
        </table>

    </div>

    <div id="employeeModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg w-1/2 p-6 shadow-lg max-h-[90vh] overflow-y-auto">
        <h2 class="text-2xl font-bold mb-4">Register New Employee</h2>
        
        <div class="mb-4">
        <label class="font-semibold">Employee Type:</label>
        <select id="employeeType" class="w-full p-2 rounded border border-gray-400">
            <option value="">Select Type</option>
            <option value="Cashier">Cashier</option>
            <option value="Waiter">Waiter</option>
            <option value="Chef">Chef</option>
        </select>
        </div>

        <form id="employeeForm" class="space-y-3">
        <!-- for all -->
        <div id="commonFields" class="hidden space-y-2">
            <input type="text" name="name" placeholder="Full Name" class="w-full p-2 rounded border border-gray-400" required>
            <input type="email" name="email" placeholder="Email" class="w-full p-2 rounded border border-gray-400">
            <input type="text" name="contact" placeholder="Contact Number" class="w-full p-2 rounded border border-gray-400">
            <input type="text" name="shift" placeholder="Shift (Morning/Evening/Night)" class="w-full p-2 rounded border border-gray-400">
        </div>

        <!-- Cashier -->
        <div id="cashierFields" class="hidden space-y-2">
            <input type="number" name="total_transactions" placeholder="Total Transactions" class="w-full p-2 rounded border border-gray-400">
            <input type="date" name="date_hired_cashier" placeholder="Date Hired" class="w-full p-2 rounded border border-gray-400">
        </div>

        <!-- Waiter -->
        <div id="waiterFields" class="hidden space-y-2">
            <input type="text" name="assigned_section" placeholder="Assigned Section" class="w-full p-2 rounded border border-gray-400">
            <input type="date" name="date_hired_waiter" placeholder="Date Hired" class="w-full p-2 rounded border border-gray-400">
        </div>

        <!-- Chef -->
        <div id="chefFields" class="hidden space-y-2">
            <input type="text" name="speciality" placeholder="Speciality" class="w-full p-2 rounded border border-gray-400">
            <input type="number" name="years_experience" placeholder="Years of Experience" class="w-full p-2 rounded border border-gray-400" min="0">
            <input type="date" name="date_hired_chef" placeholder="Date Hired" class="w-full p-2 rounded border border-gray-400">
        </div>

        <div class="flex justify-end gap-2 mt-4">
            <button type="button" id="cancelBtn" class="px-4 py-2 rounded bg-gray-400 text-white hover:bg-gray-500">Cancel</button>
            <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-500">Register</button>
        </div>
        </form>
    </div>
    </div>
</section>

<script>
  const modal = document.getElementById('employeeModal');
  const openBtn = document.getElementById('openEmployeeModal');
  const cancelBtn = document.getElementById('cancelBtn');

  const employeeTypeSelect = document.getElementById('employeeType');
  const commonFields = document.getElementById('commonFields');
  const cashierFields = document.getElementById('cashierFields');
  const waiterFields = document.getElementById('waiterFields');
  const chefFields = document.getElementById('chefFields');

  // Open modal
  openBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
  });

  // Close modal
  cancelBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
    employeeTypeSelect.value = '';
    hideAllFields();
  });

  // Hide all specific fields
  function hideAllFields() {
    commonFields.classList.add('hidden');
    cashierFields.classList.add('hidden');
    waiterFields.classList.add('hidden');
    chefFields.classList.add('hidden');
  }

  // Show fields based on selected employee type
  employeeTypeSelect.addEventListener('change', () => {
    hideAllFields();
    const type = employeeTypeSelect.value;
    if (!type) return;

    commonFields.classList.remove('hidden');
    if (type === 'Cashier') cashierFields.classList.remove('hidden');
    if (type === 'Waiter') waiterFields.classList.remove('hidden');
    if (type === 'Chef') chefFields.classList.remove('hidden');
  });
</script>
<?php require '../footer.php' ?>