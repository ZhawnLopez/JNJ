<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';

$message = "";

if (isset($_POST['update_ingredient'])) {
    $ingredient_id = (int)$_POST['ingredient_id'];
    $restock_status = $_POST['restock_status'];
    $chef_id = (int)$_POST['chef_id'];

    $update = $conn->query("
        UPDATE Ingredients 
        SET Restock_status='$restock_status', Chef_id=$chef_id, Status_updated=NOW()
        WHERE Ingredients_id=$ingredient_id
    ");

    $message = $update ? "Ingredient updated!" : "Update failed: " . $conn->error;
}

if (isset($_POST['take_order'])) {
    $order_id = (int)$_POST['order_id'];
    $chef_id = (int)$_POST['chef_id'];

    $update = $conn->query("
        UPDATE Orders 
        SET Chef_id=$chef_id
        WHERE Order_id=$order_id AND (Chef_id IS NULL OR Chef_id=0)
    ");

    $message = $update ? "Order #$order_id taken!" : "Failed to take order: " . $conn->error;
}

if (isset($_POST['mark_prepared'])) {
    $order_id = (int)$_POST['order_id'];

    $update = $conn->query("
        UPDATE Orders 
        SET Order_status='Prepared'
        WHERE Order_id=$order_id
    ");

    $message = $update ? "Order #$order_id marked as Prepared!" : "Failed to update order: " . $conn->error;
}

$ingredients = $conn->query("SELECT * FROM Ingredients ORDER BY Ingredients_id ASC");
$preparingOrders = $conn->query("
    SELECT o.*, c.Chef_name 
    FROM Orders o 
    LEFT JOIN Chef c ON o.Chef_id = c.Chef_id 
    WHERE o.Order_status='Preparing'
    ORDER BY o.Order_id ASC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chef Interface</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- u can remove this, i needed it for the orderrs and ingredients-->
    <script>
        function toggleIngredients() {
            const panel = document.getElementById('ingredientsPanel');
            panel.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen">

<h1 class="text-3xl font-bold text-center my-6">Chef Interface</h1>

<?php if(!empty($message)): ?>
<p class="text-center text-green-700 font-bold mb-4"><?= $message ?></p>
<?php endif; ?>

<div class="flex flex-col md:flex-row gap-6 mx-6 mb-8">

    <!-- order prep logic -->
    <div class="flex-1 bg-white rounded-lg shadow-lg p-4 overflow-y-auto">
        <h2 class="font-bold text-xl mb-4 border-b pb-2">Preparing Orders</h2>

        

        <h3> there isnt any Chef records in db yet </h3>
        <h11> but it do work i tried it with a sample 😭</h11>



        <?php while($order = $preparingOrders->fetch_assoc()): 
            $chef_display = $order['Chef_name'] ?? 'Unassigned';

            $order_items = json_decode($order['Order_items'], true);
            if (!is_array($order_items)) {
                $items_plain = trim($order['Order_items']);
                if (!empty($items_plain)) {
                    $order_items = [];
                    $parts = explode(',', $items_plain);
                    foreach ($parts as $part) {
                        $order_items[] = ['dish_id'=>0,'quantity'=>1,'name'=>trim($part)];
                    }
                } else $order_items = [];
            }
        ?>
        <div class="border rounded-lg p-3 mb-3 bg-yellow-50">
            <p class="font-bold">Order #<?= $order['Order_id'] ?> | Chef: <?= $chef_display ?></p>

            <?php if (!empty($order_items)): ?>
            <ul class="mb-2">
                <?php foreach($order_items as $item):
                    $dish_name = $item['name'] ?? null;
                    if (!$dish_name) {
                        $dish = $conn->query("SELECT Dish_name FROM Dish WHERE Dish_id=".(int)$item['dish_id']);
                        $dish_name = $dish ? ($dish->fetch_assoc()['Dish_name'] ?? 'Unknown') : 'Unknown';
                    }
                ?>
                    <li><?= $dish_name ?> x <?= $item['quantity'] ?? 1 ?></li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
                <p class="text-sm italic text-gray-500">No items found</p>
            <?php endif; ?>

            <form method="POST" class="flex gap-2">
                <?php if (empty($order['Chef_id']) || $order['Chef_id'] == 0): ?>
                    <input type="text" name="chef_id" placeholder="Your Chef ID" class="border p-1 rounded" required>
                    <button type="submit" name="take_order" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-500">Take Order</button>
                <?php endif; ?>
                <input type="hidden" name="order_id" value="<?= $order['Order_id'] ?>">
                <button type="submit" name="mark_prepared" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-500">Mark Prepared</button>
            </form>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- panel for ingredients to look cool -->
    <div class="w-96">
        <button onclick="toggleIngredients()" class="bg-gray-800 text-white px-3 py-2 rounded mb-2 hover:bg-gray-700 w-full">Toggle Ingredients</button>
        <div id="ingredientsPanel" class="hidden bg-white rounded-lg shadow-lg p-4 overflow-y-auto max-h-[600px]">
            <h2 class="font-bold text-xl mb-4 border-b pb-2">Ingredients</h2>


            <h3> no ingredients records in the db yet </h3>


            <table class="table-auto w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Qty</th>
                        <th class="border p-2">Restock</th>
                        <th class="border p-2">Updated By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($ing = $ingredients->fetch_assoc()): ?>
                    <tr>
                        <td class="border p-2"><?= $ing['Ingredients_name'] ?></td>
                        <td class="border p-2 text-center"><?= $ing['Quantity_available'] ?></td>
                        <td class="border p-2 text-center"><?= $ing['Restock_status'] ?></td>
                        <td class="border p-2 text-center"><?= $ing['Chef_id'] ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>

<!-- im dying -->
<!-- endfield calls to me -->
<!-- touhou whispers my name -->
<!-- the encompassing and fluffy bed waits -->
