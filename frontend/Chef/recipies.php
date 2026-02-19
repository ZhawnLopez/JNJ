<?php require '../header.php' ?>
    <p>Ingredients & Recipies</p>
</nav>
<section class="min-h-screen flex flex-1 overflow-hidden">
    <div class="w-1/5 p-6 overflow-y-auto flex flex-col gap-4 bg-gray-700 text-white font-bold *:shadow-lg *:rounded-lg *:duration-200 *:p-2 *:py-4 *:hover:bg-gray-600">
        <a href="ingredients.php">Ingredients</a>
        <a href="recipies.php">Recipies</a>
    </div>
    <div class="w-1/5 m-8 mr-0 bg-gray-300 rounded-lg p-4 shadow-lg overflow-y-auto">
        <div class="flex flex-col">
        <?php //foreach dishes as dish?>
            <form method="POST">
                <input type="hidden" name="dish_id" value="<?php //dish id ?>">
                <button type="submit"
                    class="bg-gray-100 p-4 rounded-lg hover:bg-gray-400 border border-black w-full duration-200">
                    <p class="font-bold"><?php //dish name?>Dish Name</p>
                    <p>Prep Time: 5<?php //preparation time?>m</p>
                </button>
            </form>
        <?php //endforeach; ?>
        </div>
    </div>
     <div class="flex-1 bg-gray-300 m-8 rounded-lg flex justify-center items-center">
        ingredient list of dish
     </div>
</section>
<?php require '../footer.php'?>
