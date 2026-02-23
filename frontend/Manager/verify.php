<?php require '../../backend/verifyint.php' ?>
        <p>Verify System</p>
    </div>
</nav>

<section class="min-h-[calc(100vh-60px)] flex justify-center items-center bg-gray-50 p-6">
    <form method="POST" class="bg-white shadow-xl rounded-2xl p-8 md:p-12 flex flex-col gap-6 w-full max-w-md border border-gray-100">
        
        <div class="text-center space-y-2">
            <h1 class="font-extrabold text-3xl text-gray-800">Verify Identity</h1>
            <p class="text-gray-500 text-sm">Please enter your credentials to continue.</p>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Manager Name</label>
                <input name="Manager_name" 
                    class="w-full bg-white rounded-lg border border-gray-300 p-3 outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all" 
                    placeholder="Enter your name">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" 
                    class="w-full bg-white rounded-lg border border-gray-300 p-3 outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all" 
                    placeholder="••••••••">
            </div>
        </div>

        <div class="flex flex-col gap-3 pt-2">
            <button type="submit" 
                class="w-full text-white bg-red-600 rounded-lg p-3 font-bold hover:bg-red-700 shadow-md hover:shadow-lg transform active:scale-[0.98] transition-all">
                Verify Now
            </button>

            <button type="submit" name="reset_dummy"
                class="w-full text-blue-600 bg-blue-50 rounded-lg p-3 font-semibold hover:bg-blue-100 transition-colors border border-blue-100">
                Reset with Dummy Data
            </button>
        </div>

    </form>
</section>