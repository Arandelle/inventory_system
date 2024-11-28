<?php
function Table($result, $currentPage, $totalPages)
{
  $headers = ['ID', "Name", "Cost", "Category", "Consumption_Date", "Quantity", "Action"];
  ob_start();
  ?>
        <div class="flex flex-col justify-center shadow-lg">
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
                        <td name="id" class="px-6 py-4 whitespace-nowrap"><?= $row["ID"] ?></td>
                        <td name="name" class="px-6 py-4 whitespace-nowrap"><?= $row["Name"] ?></td>
                        <td name="cost" class="px-6 py-4 whitespace-nowrap"><?= $row["Cost"] ?></td>
                        <td name="category" class="px-6 py-4 whitespace-nowrap"><?= $row["Category"] ?></td>
                        <td name="date" class="px-6 py-4 whitespace-nowrap"><?=  (new DateTime($row["ConsumptionDate"]))->format("M d, Y") ?></td>
                        <td name="quan" class="px-6 py-4 whitespace-nowrap"><?= $row["Quantity"] ?></td>
                        <td id="" class="">
                        <div class="flex flex-row space-x-2 items-center"> 
                        <button class="fa-solid fa-pencil text-green-500 bg-green-100 p-2 rounded-full"
                        onclick="ShowModal('edit', <?= htmlspecialchars(json_encode($row)) ?>)"></button>
                        
                    <!-- Delete button by post method-->
                            <form method="POST" action="sdelete.php" onsubmit="return confirm('Delete <?=  $row['Name']; ?> ?')">
                            <input type="hidden" name="id" value="<?= $row['ID'] ?>">
                            <input type="hidden" name="Name" value="<?= $row['Name'] ?>">
                            <button class="fa-solid fa-trash text-red-500 bg-red-100 p-2 rounded-full"></button>
                            </form>
                        </div>
                        </td>
                        </tr>
                    <?php endwhile; ?>
                    
                  </tbody>
                </table>
              </div>
          <!-- Pagination -->
    <div class="flex justify-center space-x-2 border-t border-t-blue-500 bg-white p-4">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1 ?>" class="px-4 py-2 bg-gray-200 rounded">Previous</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" class="px-4 py-2 <?= $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200' ?> rounded">
                <?= $i ?>
            </a>
        <?php endfor; ?>
        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>" class="px-4 py-2 bg-gray-200 rounded">Next</a>
        <?php endif; ?>
      </div>
            </div>
    
                <?php return ob_get_clean();
}

?>