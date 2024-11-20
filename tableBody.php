<?php
function Table($message, $messageType)
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
  include 'database.php';
  $result = $conn->query('SELECT * FROM daily_consumption');
  ob_start();
  ?>

        <div class="flex flex-col justify-center h-full">
        <?php if ($message): ?> 
            <p class="text-center p-2 <?php echo $messageType == 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'; ?>"> <?php echo $message; ?> </p> <?php endif; ?>

              <div  class="overflow-auto w-full">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                  <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:bg-opacity-70 dark:text-gray-400">
                    <tr>
                    <?php foreach ($headers as $key => $value) {
                      echo '<th  class="px-6 py-3"> ' . $value . '</th>';
                    } ?>
                    </tr>
                  </thead>
                  <tbody id="table-container">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border-b dark:border-gray-700 bg-white hover:bg-gray-100 dark:bg-gray-800 hover:dark:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap"><?= $row["ID"] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $row["Name"] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $row["Cost"] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $row["Category"] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $row["ConsumptionDate"] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= $row["Quantity"] ?></td>
                        <td class="space-x-2">
                          <button class="fa-solid fa-pencil text-green-500 bg-green-100 p-2 rounded-full"></button>
                          <button class="fa-solid fa-trash text-red-500 bg-red-100 p-2 rounded-full"></button>
                        </td>
                        </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
              <div class="hidden" id="modal">
          <?php include 'itemModal.php';
          echo ItemModal();
          ?>
      </div>
            </div>
    
                <?php return ob_get_clean();
}

?>