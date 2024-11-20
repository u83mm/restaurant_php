<?php 
    // Define the path to file
    $path = SITE_ROOT . "/../log/php/xdebug.log";

    // Read the content's file
    if(file_exists($path)) {
        $content_array = file($path);

        // Build an array with the last 100 lines
        $new_content_array = array_slice($content_array, count($content_array) - 100);                 

        // Create a new file with the last 10 lines in the array.
        $file = fopen($path,"w");

        foreach ($new_content_array as $key => $line) {
            fwrite($file, $line);
        }

        fclose($file);                                           
    }
?>