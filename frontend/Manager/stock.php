<?php require '../header.php' 
//check ingredient stock statuses, ask for supply
?>
    <p>Ingredients Stock</p>
</nav>

<section class="min-h-screen flex flex-1 overflow-hidden">
    
    <div class="w-1/5 p-6 overflow-y-auto flex flex-col gap-4 bg-gray-700 text-white font-bold *:shadow-lg *:rounded-lg *:duration-200 *:p-2 *:py-4 *:hover:bg-gray-600">
        <a href="dashboard.php">Dashboard</a>
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
                    <td>Good</td>
                    <td>2026-02-18 10:30:00</td>
                </tr>
            </tbody>
        </table>

    </div>

</section>

<?php require '../footer.php' ?>