<?php
    declare(strict_types=1);

    function dd($value) : void {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";

        die();
    }

    /** Router function */
    function router(array $uri = null) : void {
        $controllerNamePrefix = ucfirst("index");
        $method = "showCaptcha"; 
        $route = "";
        global $id;        
        
        // Test diferent options to configure to Controller                 
        if(count($uri) == 1 && !empty($uri[0])){
            $controllerNamePrefix = ucfirst($uri[0]);
            $method = "index";
        }
        else if(count($uri) == 2) {
            $controllerNamePrefix = ucfirst($uri[0]);
            $method = $uri[1];       
        }
        else if(count($uri) > 2) {
            if(!empty($uri) && preg_match('/^([1-9]){1,5}$/', $uri[count($uri) - 1])) {
                $id = $uri[count($uri) - 1]; 
                array_pop($uri);                                                             
            }
            else {
                foreach ($uri as $key => $value) {
                    if($key == count($uri) - 2) break;
                    $route .= $value . "/";            
                }                     
            } 

            $controllerNamePrefix = ucfirst($uri[count($uri) - 2]);
            $method = $uri[count($uri) - 1];                                                       
        }  
        
        // Build the Controller
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