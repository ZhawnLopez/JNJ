<?php require '../../backend/verifyint.php' ?>

<p>Verify</p>
</div>
</nav>

<section class="min-h-screen flex justify-center items-center text-2xl">
    <form method="POST" class="shadow-lg bg-gray-300 rounded-2xl p-14 px-25 gap-4 flex flex-col text-center w-220 h-100">

        <h1 class="font-bold text-4xl p-2 text-center">Verify</h1>

        <input name="Manager_name" class="block text-2xl bg-gray-300 rounded-md border border-gray-400 p-2" placeholder="Name">

        <input type="password" name="password" class="block text-2xl bg-gray-300 rounded-md border border-gray-400 p-2" placeholder="Password">

        <button type="submit" class="text-white text-2xl bg-red-700 mt-4 rounded-lg p-3 px-4 font-semibold hover:bg-red-600 duration-200">
            Verify
        </button>

        <!-- RESET BUTTON -->
        <button type="submit" name="reset_dummy"
            class="text-white text-xl bg-blue-700 mt-2 rounded-lg p-3 px-4 font-semibold hover:bg-blue-600 duration-200">
            Reset with Dummy Data
        </button>

    </form>
</section>