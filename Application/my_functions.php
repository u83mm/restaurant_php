<?php
    declare(strict_types=1);

    function dd($value) : void {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";

        die();
    }        
?>