<?php
    declare(strict_types=1);

    function dd($value) : void {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";

        die();
    }

    function router(array $uri = null) : void {
        $controllerNamePrefix = ucfirst("index");
        $method = "showCaptcha"; 
        $route = "";
        
        if(count($uri) == 1 && !empty($uri[0])){
            $controllerNamePrefix = ucfirst($uri[0]);
            $method = "index";
        }
        else if(count($uri) == 2) {
            $controllerNamePrefix = ucfirst($uri[0]);
            $method = $uri[1];       
        }
        else if(count($uri) > 2) {        
            foreach ($uri as $key => $value) {
                if($key == count($uri) - 2) break;
                $route .= $value . "/";            
            } 
            
            $controllerNamePrefix = ucfirst($uri[count($uri) - 2]);
            $method = $uri[count($uri) - 1];
        }  

        try {
            $controllerRoute = SITE_ROOT . "/../Controller/" . $route;        
            $controllerName = $controllerNamePrefix . "Controller";                          
           
            require_once($controllerRoute . $controllerName . ".php");          
                      
            $controller = new $controllerName;                       
            $controller->$method();
    
        } catch (\Throwable $th) {
            $error_msg = "<p class='alert alert-danger text-center'>Page not found</p>";
    
            if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                $error_msg = "<p class='alert alert-danger text-center'>
                                Message: {$th->getMessage()}<br>
                                Path: {$th->getFile()}<br>
                                Line: {$th->getLine()}
                            </p>";
            }
    
            include(SITE_ROOT . "/../view/database_error.php");
        }
    }
?>