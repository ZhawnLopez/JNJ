<?php require '../header.php' 
//login of manager, all sites under manager must kick out if not logged in
?>
    <p>Verify</p>
</nav>
<section class="min-h-screen flex justify-center items-center text-2xl">
    <form class="shadow-lg bg-gray-300 rounded-2xl p-14 px-25 gap-4 flex flex-col text-center w-220 h-100">
        <h1 class="font-bold text-4xl p-2 text-center">Verify</h1>
        <?php //space for error text?>
            <!-- <p class="p-4 flex mx-6 text-semibold rounded-lg bg-red-300 text-red-600"><?php //echo $error ?></p> -->
        <?php //endif; ?>
        <input name="Manager_name" class="block text-2xl bg-gray-300  rounded-md border border-gray-400 p-2" placeholder="Name">
        <input type="password" name="password" class="block text-2xl bg-gray-300  rounded-md border border-gray-400 p-2" placeholder="Password">
        <button class="text-white text-2xl bg-red-700 mt-4 rounded-lg p-3 px-4 font-semibold hover:bg-red-600 duration-200">Verify</button>
    </form>
</section>
