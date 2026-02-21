<?php 
require '../../backend/employeeint.php';
?>
    <p>Employee List</p>
</nav>
<!-- =================== HTML =================== -->
<section class="min-h-screen flex flex-1 overflow-hidden">
    <!-- Sidebar -->
    <div class="w-1/5 p-6 overflow-y-auto flex flex-col gap-4 bg-gray-700 text-white font-bold *:shadow-lg *:rounded-lg *:duration-200 *:p-2 *:py-4 *:hover:bg-gray-600">
        <a href="menu.php">Menu</a>    
        <a href="stock.php">Stock</a>
        <a href="employees.php">Employees</a>
    </div>

    <!-- Main Content -->
    <div class="flex-1 m-8 bg-gray-300 rounded-lg p-4 flex flex-col shadow-lg gap-4 overflow-y-auto px-10">
        <div class="flex justify-between items-center">
            <h1 class="text-5xl font-bold m-2">Employees</h1>
            <button id="openEmployeeModal" class="rounded-lg bg-green-600 text-white font-semibold p-2 px-4">Register an Employee</button>
        </div>

        <!-- Cashiers Table -->
        <p class="font-semibold text-center pb-2 border-b">Cashiers</p>
        <table class="table-fixed w-full border-collapse text-center">
            <thead>
                <tr class="bg-gray-100 *:p-2">
                    <th>ID</th><th>Name</th><th>Email</th><th>Contact</th><th>Shift</th><th>Date Hired</th><th>Total Tx</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while($c = $cashiers->fetch_assoc()): ?>
                <tr class="bg-white *:p-2 text-center">
                    <td><?= $c['Cashier_id'] ?></td>
                    <td><?= htmlspecialchars($c['Cashier_name']) ?></td>
                    <td><?= htmlspecialchars($c['Cashier_email']) ?></td>
                    <td><?= htmlspecialchars($c['Cashier_contact_num']) ?></td>
                    <td><?= htmlspecialchars($c['Cashier_shift']) ?></td>
                    <td><?= $c['Date_hired'] ?></td>
                    <td><?= $c['Total_transactions'] ?></td>
                    <td>
                        <button class="editBtn px-2 m-0.5 rounded bg-gray-200" data-type="Cashier" 
                                data-id="<?= $c['Cashier_id'] ?>"
                                data-name="<?= htmlspecialchars($c['Cashier_name']) ?>"
                                data-email="<?= htmlspecialchars($c['Cashier_email']) ?>"
                                data-contact="<?= htmlspecialchars($c['Cashier_contact_num']) ?>"
                                data-shift="<?= htmlspecialchars($c['Cashier_shift']) ?>"
                                data-date_hired="<?= $c['Date_hired'] ?>"
                                data-total_transactions="<?= $c['Total_transactions'] ?>">
                            Edit
                        </button>
                        <form method="POST" style="display:inline" onsubmit="return confirm('Delete this employee?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="employee_type" value="Cashier">
                            <input type="hidden" name="employee_id" value="<?= $c['Cashier_id'] ?>">
                            <button type="submit" class="text-red-600 font-bold">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Waiters Table -->
        <p class="font-semibold text-center pb-2 border-b">Waiters</p>
        <table class="table-fixed w-full border-collapse text-center">
            <thead>
                <tr class="bg-gray-100 *:p-2">
                    <th>ID</th><th>Name</th><th>Email</th><th>Contact</th><th>Shift</th><th>Date Hired</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while($w = $waiters->fetch_assoc()): ?>
                <tr class="bg-white *:p-2 text-center">
                    <td><?= $w['Waiter_id'] ?></td>
                    <td><?= htmlspecialchars($w['Waiter_name']) ?></td>
                    <td><?= htmlspecialchars($w['Waiter_email']) ?></td>
                    <td><?= htmlspecialchars($w['Waiter_contact_num']) ?></td>
                    <td><?= htmlspecialchars($w['Waiter_shift']) ?></td>
                    <td><?= $w['Date_hired'] ?></td>
                    <td>
                        <button class="editBtn px-2 m-0.5 rounded bg-gray-200" data-type="Waiter" 
                                data-id="<?= $w['Waiter_id'] ?>"
                                data-name="<?= htmlspecialchars($w['Waiter_name']) ?>"
                                data-email="<?= htmlspecialchars($w['Waiter_email']) ?>"
                                data-contact="<?= htmlspecialchars($w['Waiter_contact_num']) ?>"
                                data-shift="<?= htmlspecialchars($w['Waiter_shift']) ?>"
                                data-date_hired="<?= $w['Date_hired'] ?>">
                            Edit
                        </button>
                        <form method="POST" style="display:inline" onsubmit="return confirm('Delete this employee?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="employee_type" value="Waiter">
                            <input type="hidden" name="employee_id" value="<?= $w['Waiter_id'] ?>">
                            <button type="submit" class="text-red-600 font-bold">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Chefs Table -->
        <p class="font-semibold text-center pb-2 border-b">Chefs</p>
        <table class="table-fixed w-full border-collapse text-center">
            <thead>
                <tr class="bg-gray-100 *:p-2">
                    <th>ID</th><th>Name</th><th>Email</th><th>Contact</th><th>Speciality</th><th>Shift</th><th>Date Hired</th><th>Exp</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while($ch = $chefs->fetch_assoc()): ?>
                <tr class="bg-white *:p-2 text-center">
                    <td><?= $ch['Chef_id'] ?></td>
                    <td><?= htmlspecialchars($ch['Chef_name']) ?></td>
                    <td><?= htmlspecialchars($ch['Chef_email']) ?></td>
                    <td><?= htmlspecialchars($ch['Chef_contact_num']) ?></td>
                    <td><?= htmlspecialchars($ch['Speciality']) ?></td>
                    <td><?= htmlspecialchars($ch['Chef_shift']) ?></td>
                    <td><?= $ch['Date_hired'] ?></td>
                    <td><?= $ch['Years_of_experience'] ?></td>
                    <td>
                        <button class="editBtn px-2 m-0.5 rounded bg-gray-200" data-type="Chef" 
                                data-id="<?= $ch['Chef_id'] ?>"
                                data-name="<?= htmlspecialchars($ch['Chef_name']) ?>"
                                data-email="<?= htmlspecialchars($ch['Chef_email']) ?>"
                                data-contact="<?= htmlspecialchars($ch['Chef_contact_num']) ?>"
                                data-shift="<?= htmlspecialchars($ch['Chef_shift']) ?>"
                                data-date_hired="<?= $ch['Date_hired'] ?>"
                                data-speciality="<?= htmlspecialchars($ch['Speciality']) ?>"
                                data-years="<?= $ch['Years_of_experience'] ?>">
                            Edit
                        </button>
                        <form method="POST" style="display:inline" onsubmit="return confirm('Delete this employee?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="employee_type" value="Chef">
                            <input type="hidden" name="employee_id" value="<?= $ch['Chef_id'] ?>">
                            <button type="submit" class="text-red-600 font-bold">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</section>

<!-- =================== Modal (Register/Edit) =================== -->
<div id="employeeModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg w-1/2 p-6 shadow-lg max-h-[90vh] overflow-y-auto">
        <h2 class="text-2xl font-bold mb-4" id="modalTitle">Register New Employee</h2>
        <form id="employeeForm" class="space-y-3" method="POST">
            <input type="hidden" name="action" value="register" id="formAction">
            <input type="hidden" name="employee_id" value="" id="employeeId">
            <div class="mb-4">
                <label class="font-semibold">Employee Type:</label>
                <select name="employee_type" id="employeeType" class="w-full p-2 rounded border border-gray-400" required>
                    <option value="">Select Type</option>
                    <option value="Cashier">Cashier</option>
                    <option value="Waiter">Waiter</option>
                    <option value="Chef">Chef</option>
                </select>
            </div>

            <div id="commonFields" class="hidden space-y-2">
                <div>
                    <label for=name>Full Name</label>
                    <input type="text" name="name" placeholder="John Doe" class="w-full p-2 border rounded" required>
                </div>
                <div class="flex gap-2 items-center *:w-full">
                    <div>
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="sample@work.com" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label for="contact">Contact Number</label>
                        <input type="text" name="contact" placeholder="09.." class="w-full p-2 border rounded">
                    </div>
                </div>
                <div class="flex gap-2 items-center *:w-full">
                    <div>
                        <label for="shift">Shift</label>
                        <select name="shift" class="w-full p-2 border rounded">
                            <option value="">Select Shift</option>
                            <option value="Morning">Morning</option>
                            <option value="Afternoon">Afternoon</option>
                            <option value="Full">Full</option>
                        </select>
                    </div>
                    <div>
                        <label for="date_hired">Date Hired</label>
                        <input type="date" name="date_hired" class="w-full p-2 border rounded">
                    </div>
                </div>
            </div>

            <div id="cashierFields" class="hidden space-y-2 flex gap-2 items-center *:w-full">
                <div>
                    <label for="total_transactions">Total Transactions</label>
                    <input type="number" name="total_transactions" placeholder="0" class="w-full p-2 border rounded">
                </div>
            </div>

            <div id="chefFields" class="hidden space-y-2 flex gap-2 items-center *:w-full">
                <div>
                    <label for="speciality">Speciality</label>
                    <input type="text" name="speciality" placeholder="Desserts, Soups, Italian.." class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="years_experience">Years of Experience</label>
                    <input type="number" name="years_experience" placeholder="2" class="w-full p-2 border rounded" min="0">
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="cancelBtn" class="px-4 py-2 rounded bg-gray-400 text-white hover:bg-gray-500">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-500">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
// Modal control
const modal = document.getElementById('employeeModal');
const openBtn = document.getElementById('openEmployeeModal');
const cancelBtn = document.getElementById('cancelBtn');
const employeeTypeSelect = document.getElementById('employeeType');
const commonFields = document.getElementById('commonFields');
const cashierFields = document.getElementById('cashierFields');
const chefFields = document.getElementById('chefFields');
const formActionInput = document.getElementById('formAction');
const modalTitle = document.getElementById('modalTitle');
const employeeIdInput = document.getElementById('employeeId');
const employeeForm = document.getElementById('employeeForm');

openBtn.addEventListener('click', () => {
    resetEmployeeForm();
    modal.classList.remove('hidden');
});

cancelBtn.addEventListener('click', () => {
    resetEmployeeForm();
    modal.classList.add('hidden');
});

function hideAllFields() {
    commonFields.classList.add('hidden');
    cashierFields.classList.add('hidden');
    chefFields.classList.add('hidden');
}

function resetEmployeeForm() {
    employeeForm.reset(); // Clears all input values
    formActionInput.value = 'register';
    employeeIdInput.value = '';
    modalTitle.textContent = 'Register New Employee';
    employeeTypeSelect.disabled = false;
    employeeTypeSelect.value = '';
    hideAllFields();
}

// Show fields based on selected employee type
employeeTypeSelect.addEventListener('change', () => {
    hideAllFields();
    const type = employeeTypeSelect.value;
    if (!type) return;
    commonFields.classList.remove('hidden');
    if (type==='Cashier') cashierFields.classList.remove('hidden');
    if (type==='Chef') chefFields.classList.remove('hidden');
});

// Edit button functionality
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        formActionInput.value = 'edit';
        modalTitle.textContent = 'Edit Employee';
        employeeIdInput.value = btn.dataset.id;
        employeeTypeSelect.value = btn.dataset.type;
        employeeTypeSelect.disabled = true; // cannot change type

        hideAllFields();
        commonFields.classList.remove('hidden');

        // Fill common fields
        document.querySelector('[name="name"]').value = btn.dataset.name || '';
        document.querySelector('[name="email"]').value = btn.dataset.email || '';
        document.querySelector('[name="contact"]').value = btn.dataset.contact || '';
        document.querySelector('[name="shift"]').value = btn.dataset.shift || '';
        document.querySelector('[name="date_hired"]').value = btn.dataset.date_hired || '';

        // Fill type-specific fields
        if(btn.dataset.type==='Cashier'){
            cashierFields.classList.remove('hidden');
            document.querySelector('[name="total_transactions"]').value = btn.dataset.total_transactions || '';
        } else if(btn.dataset.type==='Chef'){
            chefFields.classList.remove('hidden');
            document.querySelector('[name="speciality"]').value = btn.dataset.speciality || '';
            document.querySelector('[name="years_experience"]').value = btn.dataset.years || '';
        }
    });
});

</script>

<?php require '../footer.php'; ?>
