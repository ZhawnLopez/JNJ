<?php require '../../backend/cashierint.php' ?>
        <p>Take Orders</p>
    </nav>

    <?php if(!empty($message)): ?>
        <div id="notification" class="fixed top-5 right-5 bg-gray-200 border border-5 border-green-500 p-3 rounded shadow z-50">
            <?= htmlspecialchars($message) ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
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
                    <input type="number"  name="quantity" value="1"  min="1"class="w-20 p-1 border rounded">
                    <button type="submit" name="add_to_cart"class="flex-1 bg-blue-600 text-white p-2 rounded hover:bg-blue-500"> Add</button>
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
            $discounted_total = 0;
            $discount_percentage = 0;
            if (isset($_POST['customer_type']) && $_POST['customer_type'] === 'PWD') {
                $discount_percentage = 20;
            }
            if (!empty($_SESSION['cart'])):
                foreach ($_SESSION['cart'] as $index => $item):
                    $dish_id = $item['dish_id'];
                    $quantity = $item['quantity'];
                    $result = $conn->query("SELECT Dish_name, Price FROM Dish WHERE Dish_id=$dish_id");
                    $dish = $result->fetch_assoc();
                    $item_total = $dish['Price'] * $quantity;
                    $total += $item_total;
                    // Calculate discounted total
                    $discounted_item_total = $item_total;
                    if ($discount_percentage > 0) {
                        $discounted_item_total -= $discounted_item_total * ($discount_percentage / 100);
                    }
                    $discounted_total += $discounted_item_total;
                endforeach;
            else:
                $message = "Cart is empty.";
            endif;
        ?>
        <?php if (!empty($_SESSION['cart'])): ?>
            <?php foreach ($_SESSION['cart'] as $index => $item):
                $dish_id = $item['dish_id'];
                $quantity = $item['quantity'];
                $result = $conn->query("SELECT Dish_name, Price FROM Dish WHERE Dish_id=$dish_id");
                $dish = $result->fetch_assoc();
                $item_total = $dish['Price'] * $quantity;?>
        <div class="flex justify-between items-center mb-4 bg-white p-3 rounded shadow">
            <div>
                <p class="font-semibold"><?= $dish['Dish_name'] ?></p>
                <p class="text-sm text-gray-500">
                    <?= $quantity ?> x ₱<?= number_format($dish['Price'],2); ?>
                </p>
            </div>

            <div class="flex items-center gap-3">
                <p class="font-bold">₱<?= number_format($item_total,2); ?></p>

                <form method="POST" class="items-center flex ">
                    <input type="hidden" name="cart_index" value="<?= $index ?>">
                    <button name="remove_from_cart" class="p-1 px-2 bg-gray-200 rounded-l font-semibold hover:bg-gray-100"> - </button>
                    <button type="submit"
                            name="delete_from_cart"
                            class="text-red-600 bg-red-400 font-bold hover:bg-red-200 rounded-r duration-200 p-1">
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
            <span id="display-total" data-raw-total="<?= $total ?>">₱<?= number_format($total, 2); ?></span>
        </div>

        <div id="discount-row" class="flex justify-between font-bold text-lg text-red-600 hidden">
            <span>Discount (20%):</span>
            <span id="display-discount">-₱0.00</span>
        </div>

        <div id="final-total-row" class="flex justify-between font-bold text-xl hidden border-t mt-2">
            <span>Net Total:</span>
            <span id="display-net-total">₱0.00</span>
        </div>
        


        <!-- ================== PLACE ORDER ================== -->
        <form method="POST" class="mt-6 space-y-3">
            <label for="customer_type">Customer Type:</label>
            <select name="customer_type" id="customer_type" class="w-full p-2 border rounded" onchange="applyDiscount()" required>
                <option value="Regular">Regular</option>
                <option value="PWD">PWD</option>
                <option value="Dine In">Dine In</option>
                <option value="Takeout">Takeout</option>
                <option value="Delivery">Delivery</option>
            </select>

            <div class="flex gap-2">
                <select name="cashier_id" class="w-full p-2 border rounded" required>
                    <option value="">Select Cashier</option>
                    <?php while($cashier = $cashiers->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($cashier['Cashier_id']) ?>">
                            <?= htmlspecialchars($cashier['Cashier_id']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <select name="table_id" class="w-full p-2 border rounded" required>
                    <option value="">Select Table</option>
                    <?php while($table = $availtables->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($table['Table_id']) ?>">
                            <?= htmlspecialchars($table['Table_id']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>    
            </div>
            <button id="openPaymentModal" type="button" class="w-full bg-green-600 text-white p-3 rounded hover:bg-green-500 font-bold"
            data-cashier-select="cashier_id"
            data-table-select="table_id">
                Place Order
            </button>
        </form>

<div id="paymentModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
        <!-- ================== PAYMENT ================== -->
        <form method="POST" class="bg-white rounded-lg w-1/2 p-6 shadow-lg max-h-[90vh] overflow-y-auto">
            <p class="text-center p-2 m-2 font-semibold">Waiting for Payment....</p>
            <input type="hidden" name="cashier_id" id="modalCashier">
            <input type="hidden" name="table_id" id="modalTable">
            <input type="hidden" name="customer_type" id="modalCustomerType">
            <div class="flex justify-between font-bold text-xl">
                <span>Total:</span>
                <span id="modal-base-total">₱<?= number_format($total, 2); ?></span>
            </div>

            <div id="modal-discount-row" class="justify-between font-bold text-xl text-red-600 hidden">
                <span>Discount (PWD 20%):</span>
                <span id="modal-discount-amount">-₱0.00</span>
            </div>

            <div id="modal-net-row" class="justify-between font-bold text-2xl border-t-2 border-gray-200 pt-2 hidden">
                <span>Amount to Pay:</span>
                <span id="modal-net-total">₱0.00</span>
            </div>
            <div class="flex gap-2">
                <input type="number" step="0.01" name="amount_paid" placeholder="Amount Paid" class="w-full p-2 border rounded" required>

                <select name="payment_method" id="paymentMethod" class="w-full p-2 border rounded" required>
                    <option value="Cash">Cash</option>
                    <option value="Gcash">Gcash</option>
                    <option value="Paymaya">Paymaya</option>
                </select>
            </div>
            <div id="transaciton_num">
                <label for="transaction_num">Transaction Number</label>
                <input  name="transaction_num" placeholder="Reference ID#" class="w-full p-2 border rounded">
            </div>
            <button type="button" id="cancelBtn" class="w-full bg-red-500 text-white p-2 rounded hover:bg-red-400 mt-2">
                Cancel
            </button>
            <button type="submit" name="pay_order" class="w-full bg-purple-600 text-white p-3 rounded hover:bg-purple-500 font-bold">Pay Order</button>
        </form>

    </div>
</div>
</section>


<script>
    const paymentSelect = document.getElementById('paymentMethod');
    const transactionInput = document.getElementById('transaciton_num');
    const modal = document.getElementById('paymentModal');
    const openBtn = document.getElementById('openPaymentModal');
    const cancelBtn = document.getElementById('cancelBtn');
    
    openBtn.addEventListener('click', () => {
        const cashierVal = document.querySelector('select[name="cashier_id"]').value;
        const tableVal = document.querySelector('select[name="table_id"]').value;
        const customerType = document.getElementById('customer_type').value;
        document.getElementById('modalCustomerType').value = customerType;

        const rawTotal = parseFloat(document.getElementById('display-total').dataset.rawTotal);
        const modalDiscountRow = document.getElementById('modal-discount-row');
        const modalNetRow = document.getElementById('modal-net-row');

        if (!cashierVal || !tableVal) {
            alert("Please select both a Cashier and a Table.");
            return;
        }
        //thsi can do
        //discount in modal part
        if (customerType === 'PWD') {
            const discount = rawTotal * 0.20;
            const net = rawTotal - discount;

            document.getElementById('modal-discount-amount').innerText = `-₱${discount.toFixed(2)}`;
            document.getElementById('modal-net-total').innerText = `₱${net.toFixed(2)}`;
            //show discount row
            modalDiscountRow.classList.remove('hidden');
            modalDiscountRow.classList.add('flex');
            modalNetRow.classList.remove('hidden');
            modalNetRow.classList.add('flex');
        } else {
            modalDiscountRow.classList.add('hidden');//else hid it
            modalDiscountRow.classList.remove('flex');
            modalNetRow.classList.add('hidden');
            modalNetRow.classList.remove('flex');
        }

        document.getElementById('modalCashier').value = cashierVal;
        document.getElementById('modalTable').value = tableVal;
        modal.classList.remove('hidden'); //show payment modal
    });

    cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

    paymentSelect.addEventListener('change', () => {
        const method = paymentSelect.value;
        // Logic for showing transaction number for Gcash/Paymaya
        if (method === 'Gcash' || method === 'Paymaya') {
            transactionInput.classList.remove('hidden');
            transactionInput.querySelector('input').setAttribute('required', 'required');
        } else {
            transactionInput.classList.add('hidden');
            transactionInput.querySelector('input').removeAttribute('required');
            transactionInput.querySelector('input').value = ''; 
        }
    });

    paymentSelect.dispatchEvent(new Event('change'));

    //toggles discount in cart part
    function applyDiscount() {
        const type = document.getElementById('customer_type').value;
        const rawTotal = parseFloat(document.getElementById('display-total').dataset.rawTotal);
        
        const discRow = document.getElementById('discount-row');
        const netRow = document.getElementById('final-total-row');
        
        if (type === 'PWD') {
            const discount = rawTotal * 0.20;
            const net = rawTotal - discount;
            
            document.getElementById('display-discount').innerText = `-₱${discount.toFixed(2)}`;
            document.getElementById('display-net-total').innerText = `₱${net.toFixed(2)}`;
            
            discRow.classList.remove('hidden');
            netRow.classList.remove('hidden');
        } else {
            discRow.classList.add('hidden');
            netRow.classList.add('hidden');
        }
    }
</script>

<?php require '../footer.php' ?>