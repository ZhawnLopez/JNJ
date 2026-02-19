<?php require '../header.php'; ?>
        <p>Take Orders</p>
    </nav>
<section class="min-h-screen flex flex-1 overflow-hidden">

    <!-- ================== DISHES ================== -->
    <div class="w-2/3 p-6 overflow-y-auto">
        <div class="grid gap-4 grid-cols-4 rounded-2xl shadow-lg p-4 bg-white">

        <?php foreach($dishes as $dish): ?>
            <form method="POST" class="border rounded-xl p-3 hover:shadow-lg duration-200 bg-gray-50">
                
                <input type="hidden" name="dish_id" value="<?= $dish['Dish_id'] ?>">

                <p class="font-bold text-lg"><?= $dish['Dish_name'] ?></p>
                <p class="text-gray-600 mb-2">₱<?= number_format($dish['Price'],2); ?></p>

                <div class="flex gap-2">
                    <input type="number" 
                           name="quantity" 
                           value="1" 
                           min="1"
                           class="w-20 p-1 border rounded">

                    <button type="submit" 
                            name="add_to_cart"
                            class="flex-1 bg-blue-600 text-white p-2 rounded hover:bg-blue-500">
                        Add
                    </button>
                </div>
            </form>
        <?php endforeach; ?>

        </div>
    </div>


    <!-- ================== CART ================== -->
    <div class="w-1/3 bg-gray-100 p-6 overflow-y-auto">
        <h2 class="text-2xl font-bold mb-4">🛒 Cart</h2>

        <?php
        $total = 0;

        if (!empty($_SESSION['cart'])):
            foreach ($_SESSION['cart'] as $index => $item):

                $dish_id = $item['dish_id'];
                $quantity = $item['quantity'];

                $result = $conn->query("SELECT Dish_name, Price FROM Dish WHERE Dish_id=$dish_id");
                $dish = $result->fetch_assoc();

                $item_total = $dish['Price'] * $quantity;
                $total += $item_total;
        ?>

        <div class="flex justify-between items-center mb-4 bg-white p-3 rounded shadow">
            <div>
                <p class="font-semibold"><?= $dish['Dish_name'] ?></p>
                <p class="text-sm text-gray-500">
                    <?= $quantity ?> x ₱<?= number_format($dish['Price'],2); ?>
                </p>
            </div>

            <div class="flex items-center gap-3">
                <p class="font-bold">₱<?= number_format($item_total,2); ?></p>

                <form method="POST">
                    <input type="hidden" name="cart_index" value="<?= $index ?>">
                    <button type="submit"
                            name="remove_from_cart"
                            class="text-red-600 font-bold hover:scale-110">
                        ✕
                    </button>
                </form>
            </div>
        </div>

        <?php endforeach; ?>

        <?php else: ?>
            <p class="text-gray-500">Cart is empty.</p>
        <?php endif; ?>


        <hr class="my-4">

        <div class="flex justify-between font-bold text-xl">
            <span>Total:</span>
            <span>₱<?= number_format($total,2); ?></span>
        </div>


        <!-- ================== PLACE ORDER ================== -->
        <form method="POST" class="mt-6 space-y-3">

            <select name="customer_type" class="w-full p-2 border rounded" required>
                <option value="Regular">Regular</option>
                <option value="PWD">PWD</option>
                <option value="DineIn">Dine In</option>
                <option value="Takeout">Takeout</option>
                <option value="Delivery">Delivery</option>
            </select>

            <div class="flex gap-2">
                <input name="cashier_id" 
                       placeholder="Cashier ID" 
                       class="w-full p-2 border rounded" required>

                <input name="table_id" 
                       placeholder="Table #" 
                       class="w-full p-2 border rounded" required>
            </div>

            <button type="submit" 
                    name="place_order"
                    class="w-full bg-green-600 text-white p-3 rounded hover:bg-green-500 font-bold">
                Place Order
            </button>
        </form>


        <!-- ================== PAYMENT ================== -->
        <form method="POST" class="mt-6 space-y-3">

            <input type="number" name="order_id" placeholder="Order ID"
                   class="w-full p-2 border rounded" required>

            <div class="flex gap-2">
                <input type="number" step="0.01"
                       name="amount_paid"
                       placeholder="Amount Paid"
                       class="w-full p-2 border rounded"
                       required>

                <select name="payment_method"
                        id="paymentMethod"
                        class="w-full p-2 border rounded"
                        required>
                    <option value="Cash">Cash</option>
                    <option value="Gcash">Gcash</option>
                    <option value="Paymaya">Paymaya</option>
                </select>
            </div>

            <button type="submit"
                    name="pay_order"
                    class="w-full bg-purple-600 text-white p-3 rounded hover:bg-purple-500 font-bold">
                Pay Order
            </button>
        </form>

    </div>
</section>


<script>
    const paymentSelect = document.getElementById('paymentMethod');
    const transactionInput = document.getElementById('transactionIdInput');

    paymentSelect.addEventListener('change', () => {
        const method = paymentSelect.value;
        if (method === 'Gcash' || method === 'Paymaya') {
            transactionInput.classList.remove('hidden');
            transactionInput.setAttribute('required', 'required');
        } else {
            transactionInput.classList.add('hidden');
            transactionInput.removeAttribute('required');
            transactionInput.value = ''; // clear input
        }
    });

// trigger on page load in case default is Gcash/Paymaya
    paymentSelect.dispatchEvent(new Event('change'));
</script>

<?php require '../footer.php' ?>