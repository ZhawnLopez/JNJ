<?php require '../header.php'; ?>
    <p>Transaction</p>
</nav>
<section class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md text-center">

        <h2 class="text-2xl font-bold mb-6 text-green-600">Transaction Successful</h2>
        <div class="space-y-2 text-left">
            <p><strong>Transaction #:</strong> TXN-123456</p>
            <p><strong>Date:</strong> 2026-02-19 14:35:22</p>
            <p><strong>Total Amount:</strong> ₱500.00</p>
            <p><strong>Amount Paid:</strong> ₱1000</p>
            <p><strong>Change:</strong> ₱500</p>
            <p><strong>Payment Method:</strong> Cash</p>
            <p><strong>Status:</strong> Paid</p>
        </div>
        <a href="dishes.php" class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-500 duration-200">
            Go Back
        </a>
    </div>
</section>

<?php require '../footer.php'; ?>
