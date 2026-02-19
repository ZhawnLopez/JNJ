<?php require '../header.php'
//list of employees, cashiers, chefs, waiters, can register them through here and set passcode?>
    <p>Employee List</p>
</nav>
<section class="min-h-screen flex flex-1 overflow-hidden">
    <div class="w-1/5 p-6 overflow-y-auto flex flex-col gap-4 bg-gray-700 text-white font-bold *:shadow-lg *:rounded-lg *:duration-200 *:p-2 *:py-4 *:hover:bg-gray-600">
        <a href="dashboard.php">Dashboard</a>
        <a href="stock.php">Stock</a>
        <a href="employees.php">Employees</a>
    </div>
    
    <div class="flex-1 m-8 bg-gray-300 rounded-lg p-4 flex flex-col shadow-lg gap-4 overflow-y-auto px-10">
        <h1 class="text-5xl font-bold m-2">Employees</h1>
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
</section>

<?php require '../footer.php' ?>