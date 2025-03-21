<?php      
    declare(strict_types=1);

    namespace Application\Controller\admin;

    use Application\Controller\admin\AdminController;
    use Application\Core\Controller;
    use Application\model\classes\Language;
    use Application\model\classes\Query; 

    class MenuDayController extends Controller
    {
        /** Create array and object for diferent languages */    
        private Language $languageObject;

        public function __construct(            
            private string $message = "",
            private array $language = [],
        )
        {
            /** Configure page language */
            $this->languageObject = new Language(); 
            $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english(); 
        }

        public function index(): void
        {
            try { 
                /** Build the objects */
                $query = new Query();
                $adminController = new AdminController();

                /** Get the price from the form */
                if(isset($_REQUEST['price'])) {
                    $price = floatval($_REQUEST['price']) ?? "El precio del Menú del día debe de ser un dato numérico";
                    
                    if(!is_numeric($price)) throw new \Exception($price);

                    $fields = [
                        "price" => $price
                    ];
                    
                    # Código para almacenar el dato en la tabla "menu_day_price"
                    $rows = $query->selectCount("menu_day_price");
                    if($rows) $query->truncateTable("menu_day_price");

                    $query->insertInto("menu_day_price",$fields);
                }                               
                                
                $this->message = "<p class='alert alert-success text-center'>" . ucfirst($this->language['updated_price']) . "</p>";
                $adminController->adminMenus($this->message);
            } 
            catch (\Exception $e) {
                $this->message = "<p class='alert alert-danger text-center'>{$e->getMessage()}</p>";                                               
                $adminController->adminMenus($this->message);
            } 
            catch (\Throwable $th) {
                $this->message = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
                        de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                
                $this->render("/view/database_error.php", ["message" => $this->message]);	
            }            
        }
    }    
?>