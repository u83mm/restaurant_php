<?php
    declare(strict_types=1);

    namespace Application\Core;

    use model\classes\AccessControl;

    class Controller
    {
        use AccessControl;

        /** Render templates */
        function render(string $path, array $data = []) : void {
            try {
                if($data) extract($data);
    
                require_once(SITE_ROOT . "/../Application" . $path);
                unset($_SESSION['message']);
                die;
    
            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1); 
            } 
        }
    }    
?>