
<?php require '../header.php' 
//displays new orders, and currently preparing orders (orders that are taken by other chefs already)
?>
    <p>Orders</p>
</nav>
<section class="min-h-screen flex flex-1 overflow-hidden">
    <div class="flex-1 m-8 mr-0 bg-gray-300 rounded-lg p-4 shadow-lg overflow-y-auto">
       <h1 class="font-bold text-center text-2xl pb-4 border-b">New Orders</h1>
       <div class="grid grid-cols-3 overflow-y-auto">
            <div class="rounded-lg border bg-gray-200 flex flex-col items-center justify-center m-2 p-2">
                <p class="font-bold p-2 text-lg">Order#</p>
                <div class="w-full flex flex-col">
                    <div class=" flex justify-between">
                        <p class="font-light">Dishes</p>
                        <p class="font-light">x2</p>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <div class="flex-1 m-8 mr-0 bg-gray-300 rounded-lg p-4 shadow-lg overflow-y-auto">
        <div class="flex flex-col">
            <h1 class="font-bold text-center text-2xl pb-4 border-b">Preparing Orders</h1>
        <?php //foreach order with chef id?>
            <div class="grid grid-cols-3 overflow-y-auto">
                <div class="rounded-lg border bg-gray-200 flex flex-col items-center justify-center m-2 p-2">
                    <p class="font-bold p-2 text-lg">Order#</p>
                    <div class="pb-2 border-b w-full flex flex-col">
                        <div class=" flex justify-between">
                            <p class="font-light">Dishes</p>
                            <p class="font-light">x2</p>
                        </div>
                    </div>
                    <p>Chef: <?php //chef name ?></p>
                </div>    
            </div>
        <?php //endforeach; ?>
        </div>
    </div>
</section>
<?php require '../footer.php'?>
