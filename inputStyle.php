<?php 
    function InputStyle($label, $type, $icon, $placeholder) {
        ob_start();
        ?>
        
       <div class="space-y-1">
            <label for="" class="text-sm text-gray-500 font-semibold"><?php echo $label; ?></label>
            <div class="relative w-full sm:w-auto">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                  <i class="fa-solid <?php echo $icon; ?> text-blue-500"></i>
                </div>
                <input 
                    type="<?php echo htmlspecialchars($type); ?>"
                    class="block w-full sm:w-80 p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50  focus:outline-none focus:border-2 focus:border-gray-200"
                    placeholder="Enter the <?php echo htmlspecialchars($placeholder); ?>"
                >
            </div>
       </div>

        <?php return ob_get_clean();
    }
?>