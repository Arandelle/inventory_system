<?php 
 function Pagination() {
    ob_start();
    ?>
    <nav
      class="flex flex-col sm:flex-row items-center justify-between p-4 space-y-4 sm:space-y-0 bg-white dark:bg-gray-800"
      aria-label="Table navigation"
    >
      <span class="text-sm font-normal text-gray-500 dark:text-gray-400 w-full sm:w-auto">
        <span class="font-semibold text-gray-900 dark:text-white">
            1 of 10 to 20
        </span>
      </span>

      <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
        <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
          <button
            class="flex items-center justify-center px-3 h-8 ms-0 rounded-s-lg leading-tight border border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          >
            Previous
          </button>
              <button
                class="hidden sm:flex items-center justify-center px-3 h-8 leading-tight
                text-gray-900 bg-primary-300 border border-gray-400 hover:bg-primary-400 hover:text-gray-700 dark:bg-gray-600 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white"
              >
                1
              </button>
          <button
            class="flex items-center justify-center px-3 h-8 leading-tight border border-gray-300 rounded-e-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          >
            Next
          </button>
        </ul>

        <form onSubmit={handleJumpToPage} class="flex items-center">
          <label
            htmlFor="jumpToPage"
            class="mr-2 text-gray-600 dark:text-gray-400 text-sm"
          >
            Jump to:
          </label>
          <input
            type="number"
            class="border px-2 py-1 h-8 w-16 dark:bg-gray-600 dark:text-white text-sm"
          />
          <button
            type="submit"
            class="ml-2 px-3 py-1 h-8 bg-primary-500 dark:bg-primary-400 text-white rounded text-sm"
          >
            Go
          </button>
        </form>
      </div>
      <div></div>
    </nav>

    <?php return ob_get_clean();
 }

?>