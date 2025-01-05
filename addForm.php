<?php

function SelectStyle($label, $icon, $name, $id, $options)
{
    $optionsHTML = '';
    foreach ($options as $value) {
        $optionsHTML .= "<option value='$value'>$value</option>";
    }

    return "
    <div class='space-y-1'>
        <label for='$id' class='text-sm text-gray-500'>$label</label>
        <div class='relative w-full sm:w-auto'>
            <div class='absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none'>
                <i class='fa-solid $icon text-blue-500'></i>
            </div>
            <select name='$name' id='$id' class='block w-full sm:w-80 p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-2 focus:border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white'>
                $optionsHTML
            </select>
        </div>
    </div>
    ";
}

function addForm()
{
    ob_start();
    $categories = ["Shirt", "Casual", "Sportswear", "Dress"];
    $colors = ["Red", "Blue", "Black", "White"];
    $sizes = ["XS", "Small", "Medium", "Large"];
?>
    <form method="POST" action="./actions/add.php" enctype="multipart/form-data" class="fixed flex items-center justify-center inset-0 z-50">
        <div class="fixed h-full w-full bg-gray-600 bg-opacity-50" onclick="ShowModal('add')">
        </div>
        <div class="relative bg-white p-4 gap-4 flex flex-col space-y-2 rounded-md shadow-lg">
            <p class="text-blue-500 text-center font-bold w-full">Add new item</p>
            <?php include 'inputStyle.php'; ?>

            <div class="flex flex-row space-x-4">
            <div class="space-y-2">
                <?= InputStyle("Name: ", "text", "fa-list-ul", "item", "title"); ?>
                <?= InputStyle("Cost: ", "number", "fa-money-bill-1", "cost", "price"); ?>
                <?= SelectStyle("Category: ", "fa-tags", "category", "category", $categories); ?>
                <?= SelectStyle("Color: ", "fa-palette", "color", "color", $colors); ?>
            </div>

            <div class="space-y-2">
                <?= SelectStyle("Size: ", "fa-ruler", "size", "size", $sizes); ?>
                <?= InputStyle("Quantity: ", "number", "fa-list-ol", "quantity", "quantity"); ?>
                <?= InputStyle("Description: ", "text", "fa-align-left", "description", "description"); ?>

                <div class="space-y-1 w-full sm:w-auto">
                    <label for="image" class="text-sm text-gray-500">Upload Image: </label>
                    <input type="file" name="image" id="image" class="block w-full sm:w-80 p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:border-2 focus:border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" />
                </div>
            </div>
            </div>
            <button type="submit" class="w-full items-center text-white bg-blue-500 hover:bg-blue-600 rounded-lg text-sm p-2 shadow-lg">
                Confirm
            </button>
        </div>
    </form>
<?php
    return ob_get_clean();
}
?>