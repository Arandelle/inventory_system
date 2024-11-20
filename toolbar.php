<?php

include 'database.php';



function Toolbar()
{
    ob_start(); 
    ?>
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-3 bg-white dark:bg-gray-800 rounded-t-md shadow-md">
        <button class="inline-flex space-x-2 justify-center items-center text-nowrap text-gray-500 bg-gray-100 border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"

        id="addItem"
        onclick="AddItem()"
        >
        <i class="fa-solid fa-plus"></i>
        <p> Add new consumption</p>
        </button>
        <p class="text-md lg:text-lg font-bold text-gray-600 dark:text-green-500 text-center w-full sm:w-auto">
            Daily Consumption Tracker
        </p>
        <div class="relative w-full sm:w-auto">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <i class="fa-solid fa-search text-gray-500"></i>
            </div>
            <input 
                type="text"
                class="block w-full sm:w-80 p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50  focus:outline-none focus:border-2 focus:border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                placeholder="Search something..."
            >
        </div>
    </div>
    <?php 
    return ob_get_clean();
}

?>
