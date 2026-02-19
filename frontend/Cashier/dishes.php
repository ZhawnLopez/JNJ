
<?php
    require '../header.php'
?>
        <p>Take Orders</p>
    </nav>
<section class="min-h-screen flex flex-1 overflow-hidden">
    <div class="w-2/3 p-6 overflow-y-auto">
        <div class="grid gap-4 grid-cols-4 rounded-2xl shadow-lg shadow-gray-300/60 p-4">
        <?php //foreach dishes as dish?>
            <form method="POST">
                <input type="hidden" name="dish_id" value="<?php //dish id ?>">
                <button type="submit"
                    class="bg-gray-100 p-4 rounded-lg hover:bg-gray-300 border border-black w-full duration-200">
                    <p class="font-bold"><?php //dish name?>Dish Name</p>
                    <p>₱<?php //number_format(dishprice,2); ?>90.00</p>
                </button>
            </form>
        <?php //endforeach; ?>
        </div>
    </div>
    <div class="w-1/3 bg-gray-300 p-6 overflow-y-auto">
        <h2 class="text-2xl font-bold mb-4">Cart</h2>
        <?php //calculate total price of every dish ?>
        <div class="flex justify-between items-center mb-3">
            <div>
                <p><?php //echo dish name ?>Food</p>
                <p class="text-sm opacity-80">
                    <?php //echo quantity ?>2 x ₱<?php //number_format(dish price),2); ?>80.00
                </p>
            </div>

            <div class="flex items-center gap-3">
                <p>₱<?php //number_format(total price dish,2); ?>160</p>
                <form method="POST">
                    <input type="hidden" name="remove_id" value="<?php //dish id ?>">
                    <button class="text-red-800 hover:scale-105 hover:text-red-500">✕</button>
                </form>
            </div>
        </div>
        <?php //endforeach; ?>
        <hr class="my-4">
        <div class="flex justify-between font-bold text-xl">
            <span>Total:</span>
            <span>₱<?php //echo number_format($total,2); ?>180</span>
        </div>
        <!-------------payment-->
        <form method="POST" class="mt-4 space-y-3">
            <div class="flex gap-2">
                <input name="cashier_id" placeholder="CashierID" class="w-full p-2 rounded-lg border border-black" required>
                <input name="table_id" placeholder="Table#" class="w-full p-2 rounded-lg border border-black" required>
            </div>
            <div class="flex gap-2">
                <input type="number" step="0.01" name="amount_paid" placeholder="Amount Paid" class="w-full p-2 rounded-lg border border-black" required>
                <select name="payment_method" id="paymentMethod"
                    class="w-full p-2 rounded-lg *:bg-gray-300 border border-black" required>
                    <option value="Cash">Cash</option>
                    <option value="Gcash">Gcash</option>
                    <option value="Paymaya">Paymaya</option>
                </select>
            </div>

            <!-- Transaction ID input (hidden by default) -->
            <input type="text" name="transaction_id" id="transactionIdInput" class="w-full p-2 rounded-lg border border-black hidden" placeholder="Transaction #" >

            <button type="submit" name="checkout" class="w-full bg-green-600 p-3 rounded-lg hover:bg-green-500 font-bold duration-200">
                Checkout
            </button>
        </form>
        </div>
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