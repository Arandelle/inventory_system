<?php
function Table($page = 1, $items_per_page = 10)
{
  include 'database.php';
  $headers = ['ID', "Name", "Cost", "Category", "Consumption_Date", "Quantity", "Action"];
  $offset = ($page - 1) * $items_per_page;
  $total_result = $conn->query('SELECT COUNT(*) as total FROM daily_consumption');
  $total_rows = $total_result->fetch_assoc()['total'];
  $total_pages = ceil($total_rows / $items_per_page);
  $result = $conn->query("SELECT * FROM daily_consumption LIMIT $items_per_page OFFSET $offset");
  ob_start();
  ?>
        <div class="flex flex-col justify-center">
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
                    <?php 
                    while ($row = $result->fetch_assoc()): ?>
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
                  <!-- Pagination Controls -->
        <div class="flex justify-center space-x-2 mt-4">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Previous</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="px-4 py-2 <?= $i == $page ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' ?> rounded">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Next</a>
            <?php endif; ?>
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