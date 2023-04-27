<?php
    namespace Controller\orders;

    use model\classes\QueryMenu;

    class OrderController
    {
        public function __construct(private object $dbcon)
        {
                        
        }
      
        public function index()
        {
            try { 
                $table_number = $_POST['table_number'] ?? 0;
                $people_qty = $_POST['people_qty'] ?? 0;               

                /** Create arrays for tables numbers and people quantity */               
                $tables = $persones = []; 
                for($i = 1; $i <= 20; $i++) $tables[] = $i;
                for($i = 1; $i <= 40; $i++) $persones[] = $i;
                
                include(SITE_ROOT . "/../view/orders/new_view.php");

            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

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
    }    
?>  