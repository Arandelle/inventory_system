<?php 

    function addForm(){
        ob_start();
        ?>
        <form method="POST" action="./actions/add.php"
        class="fixed flex items-center justify-center inset-0 z-50">
         <div class="fixed h-full w-full bg-gray-600 bg-opacity-50"
            onclick="ShowModal('add')">
        </div>
         <div class="relative bg-white p-4 flex flex-col space-y-4 rounded-md shadow-lg">
         <p class="text-blue-500 text-center font-bold">Add your expenses</p>
            <?php 
            include 'inputStyle.php'; ?>

            <?= InputStyle("Name: ", "text", "fa-list-ul", "consumption", "name"); ?>
            <?= InputStyle("Cost: ", "number", "fa-money-bill-1", "cost", "cost"); ?>

          <div class="space-y-1">
                <label for="" class="text-sm text-gray-500">Category: </label>
                <div class="relative w-full sm:w-auto">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                          <i class="fa-solid fa-tags text-blue-500"></i>
                        </div>
                     <select name="category" id="category" class="block w-full sm:w-80 p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50  focus:outline-none focus:border-2 focus:border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            <option value="Food">Food</option>
                            <option value="Transport">Transport</option>
                            <option value="Beverages">Beverages</option>
                            <option value="Garments">Garments</option>
                    </select>
                </div>
          </div>

            <?= InputStyle("Date: ", "date", "fa-calendar", "date", "date"); ?>
            <?= InputStyle("Quantity: ", "number", "fa-list-ol", "quantity", "quan"); ?>

            <button type="submit" class="items-center text-white bg-blue-500 hover:bg-blue-600  rounded-lg text-sm p-2 shadow-lg">
                Confirm
            </button>
         </div>
    </form>

        <?php return ob_get_clean();
    }

?>