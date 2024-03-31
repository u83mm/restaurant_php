<?php      
    //namespace Controller\admin;
    
    //use Exception;
    
    use model\classes\Query; 

    class MenuDayController
    {
        public function __construct(private object $dbcon = DB_CON)
        {
            
        }

        public function index(): void
        {
            try { 
                /** Build the objects */
                $query = new Query();
                $adminController = new AdminController($this->dbcon);

                /** Get the price from the form */
                $price = $_REQUEST['price'] ?? "El precio del Menú del día debe de ser un dato numérico";                
                if(!is_numeric($price)) throw new Exception($price);

                $fields = [
                    "price" => $price
                ];
                
                # Código para almacenar el dato en la tabla "menu_day_price"
                $rows = $query->selectCount("menu_day_price", $this->dbcon);
                if($rows) $query->truncateTable("menu_day_price", $this->dbcon);

                $query->insertInto("menu_day_price",$fields, $this->dbcon);
                $message = "<p class='alert alert-success text-center'>Precio actualizado</p>";
                $adminController->adminMenus($message);
            } 
            catch (\Exception $e) {
                $error_msg = "<p class='alert alert-danger text-center'>{$e->getMessage()}</p>";                                               
                $adminController->adminMenus($error_msg);
            } 
            catch (\Throwable $th) {
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
                        de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";                        
                include(SITE_ROOT . "/../view/database_error.php");	
            }            
        }
    }
    
?>