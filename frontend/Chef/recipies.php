<?php require '../../backend/chefint.php' ?>
    <p class="font-semibold tracking-wide">Ingredients & Recipes</p>
</nav>

<section class="h-[calc(100vh-64px)] flex overflow-hidden bg-gray-50">
    <div class="w-1/5 p-6 overflow-y-auto flex flex-col gap-4 bg-gray-700 text-white font-bold *:shadow-lg *:rounded-lg *:duration-200 *:p-2 *:py-4 *:hover:bg-gray-600">
        <a href="ingredients.php">Ingredients</a>
        <a href="recipies.php">Recipies</a>
    </div>
<div class="flex w-full m-8 bg-gray-300 rounded-lg p-6 shadow-lg overflow-auto">
    <div class="w-[30%] overflow-y-auto">
        <div class="p-4 space-y-3">
            <h2 class="text-5xl font-bold m-2">Select a Dish</h2>
            <?php while($dish = $dishes->fetch_assoc()): ?>
                <form method="POST">
                    <input type="hidden" name="dish_id" value="<?= $dish['Dish_id'] ?>">
                    <button type="submit"
                        class="group w-full text-left p-4 rounded-xl border transition-all duration-200 
                        <?= ($selected_dish_id == $dish['Dish_id']) 
                            ? 'bg-red-50 border-red-200 shadow-sm' 
                            : 'bg-white border-gray-100 hover:border-red-200 hover:bg-gray-50' ?>">
                        
                        <div class="flex justify-between items-start">
                            <p class="font-bold text-lg <?= ($selected_dish_id == $dish['Dish_id']) ? 'text-red-700' : 'text-gray-800' ?>">
                                <?= htmlspecialchars($dish['Dish_name']) ?>
                            </p>
                            <span class="text-xs font-medium px-2 py-1 rounded-md bg-gray-100 text-gray-500 group-hover:bg-white transition-colors">
                                <?= $dish['Preparation_timeMin'] ?>m
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1 italic">Click to view recipe</p>
                    </button>
                </form>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto rounded-xl p-10 bg-gray-50">
        <?php if($selected_dish_id && $selected_dish): ?>
            <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="border-b border-gray-100 pb-6 mb-6">
                    <h2 class="text-4xl font-extrabold text-gray-900 leading-tight">
                        <?= htmlspecialchars($selected_dish['Dish_name']) ?>
                    </h2>
                    <div class="flex gap-4 mt-4 text-sm text-gray-500 font-medium">
                        <span class="flex items-center gap-1">⏱ <?= $selected_dish['Preparation_timeMin'] ?> mins</span>
                        <span>•  Category: </span>
                        <span class="text-red-600"><?= $selected_dish['Dish_category'] ?></span>
                    </div>
                </div>
                
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-2 h-6 bg-red-500 rounded-full"></span>
                    Ingredients List
                </h3>
                
                <div class="prose prose-slate max-w-none text-gray-600 text-lg leading-relaxed">
                    <p class="whitespace-pre-line"><?= htmlspecialchars($selected_dish['Ingredients']) ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="h-full flex flex-col items-center justify-center text-gray-400">
                <div class="w-16 h-16 mb-4 opacity-20 bg-gray-400 rounded-full flex items-center justify-center text-3xl">🍳</div>
                <p class="text-xl font-medium">Select a dish from the left to view the prep details.</p>
            </div>
        <?php endif; ?>
    </div>
    </div>
</section>
<?php require '../footer.php'?>