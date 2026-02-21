<?php require '../../backend/paymentint.php'; ?>
    <p>Transaction</p>
</nav>
<section class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md text-center">

        <h2 class="text-2xl font-bold mb-6 text-green-600">Transaction Successful</h2>
        <div class="space-y-2 text-left">
            <p><strong>Transaction #:</strong> <?php echo htmlspecialchars($transaction_num); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($transaction_date); ?></p>
            <p><strong>Cashier:</strong> <?php echo htmlspecialchars($cashier_name); ?></p>

            <hr class="my-2">

            <h3 class="font-semibold mt-2">Order Items:</h3>
            <?php if (!empty($items)) : ?>
                <?php foreach ($items as $item) : ?>
                    <p>
                        <?php echo htmlspecialchars($item['dish_name']); ?> 
                        x<?php echo (int)$item['quantity']; ?> 
                        - ₱<?php echo number_format((float)$item['price'] * (int)$item['quantity'], 2); ?>
                    </p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No items found.</p>
            <?php endif; ?>

            <hr class="my-2">

            <p><strong>Total Amount:</strong> ₱<?php echo number_format((float)$total_amount, 2); ?></p>
            <p><strong>Amount Paid:</strong> ₱<?php echo number_format((float)$amount_paid, 2); ?></p>
            <p><strong>Change:</strong> ₱<?php echo number_format((float)$amount_paid - (float)$total_amount, 2); ?></p>
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($status); ?></p>
        </div>

        <a href="dishes.php" class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-500 duration-200">
            Go Back
        </a>
    </div>
</section>

<?php require '../footer.php'; ?>