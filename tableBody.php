<?php

function Table()
{
  $headers = ['ID', "Name", "Cost", "Category", "Consumption_Date", "Quantity", "Action"];
  $data = [
    ["id" => 1, "name" => "pamasahe", "cost" => 20, "category" => "transportation", "date" => "july 20", "quan" => 30],
    [
      "id" => 2,
      "name" => "foods",
      "cost" => 80,
      "category" => "lunch",
      "date" => "july 30",
      "quan" => 24
    ]
  ];
  ob_start();
  ?>

      <div class="flex flex-col justify-center h-full">
            <div class="overflow-auto w-full">
              <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:bg-opacity-70 dark:text-gray-400">
                  <tr>
                  <?php foreach ($headers as $key => $value) {
                    echo '<th  class="px-6 py-3"> ' . $value . '</th>';
                  } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($data as $item) : ?>
                    <tr class="border-b dark:border-gray-700 bg-white hover:bg-gray-100 dark:bg-gray-800 hover:dark:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap"><?= $item["id"] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $item["name"] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $item["cost"] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $item["category"] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $item["date"] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $item["quan"] ?></td>
                    <td class="space-x-2">
                      <button class="fa-solid fa-eye text-blue-500 bg-blue-100 p-2 rounded-full"></button>
                      <button class="fa-solid fa-pencil text-green-500 bg-green-100 p-2 rounded-full"></button>
                      <button class="fa-solid fa-trash text-red-500 bg-red-100 p-2 rounded-full"></button>
                    </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
    
              <?php return ob_get_clean();
}

?>