

<?php require '../header.php' 
//display if orders are prepared or preparing?>
    <p>Prepared Orders</p>
</nav>
<section class="min-h-screen flex flex-1 overflow-hidden">
    <div class="flex flex-col flex-1">
        <div class="flex-1 m-8 mr-0 bg-gray-300 rounded-lg p-4 shadow-lg overflow-y-auto">
        <h1 class="font-bold text-center text-2xl pb-4 border-b">Preparing</h1>
        <div class="grid grid-cols-3 overflow-y-auto">
                <div class="rounded-lg border bg-gray-200 flex flex-col items-center justify-center m-2 p-2">
                    <p class="font-bold p-2 text-lg">Order#</p>
                </div>    
            </div>
        </div>
        <div class="flex-1 m-8 mr-0 mt-0 bg-gray-300 rounded-lg p-4 shadow-lg overflow-y-auto">
            <div class="flex flex-col">
                <h1 class="font-bold text-center text-2xl pb-4 border-b">Prepared</h1>
            <?php //foreach order ?>
                <div class="grid grid-cols-3 overflow-y-auto">
                    <div class="rounded-lg border bg-gray-200 flex flex-col items-center justify-center m-2 p-2">
                        <p class="font-bold p-2 text-lg">Order#</p>
                        <p class="font-light text-sm">Table#</p>
                    </div>    
                </div>
            <?php //endforeach; ?>
            </div>
        </div>
    </div>
    <div class="flex-1 m-8 bg-gray-300 rounded-lg p-4 shadow-lg overflow-y-auto">
        <div class="flex flex-col">
            <h1 class="font-bold text-center text-2xl pb-4 border-b">Tables</h1>
        <?php //foreach table number?>
            <div class="rounded-lg border bg-gray-200 flex items-center justify-between m-2 p-2">
                <p class="font-bold p-2 text-lg">Table#</p>
                <select class="bg-gray-200 p-2 px-4 rounded-lg border border-gray-400 appearance-none *:bg-gray-200">
                    <option value="Clean">Clean</option>
                    <option value="Dirty">Dirty</option>
                    <option value="Occupied">Occupied</option>
                </select>
            </div>    
        <?php //endforeach; ?>
        </div>
    </div>
</section>
<?php require '../footer.php'?>
