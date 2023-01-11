<?php
    namespace Controller\admin;

    use model\classes\Query;
    use model\classes\QueryMenu;
    use model\classes\Validate;
    use PDO;
    use PDOException;

    class DishesController
    {        
        public function __construct(private object $dbcon)
        {

        }      

        /** Show dishes index */
        public function index(string $message = null, string $p = null, string $s = null): void
        {
            try {                                
                /** Calculate necesary pages for pagination */ 

                $pagerows = 6; // Number of rows for page.
                $desde = 0;
                $query = new Query();

                $total_rows = $query->selectCount('dishes', $this->dbcon);
                $pagina = 1;

                if(!$total_rows) throw new PDOException("<p class='alert alert-danger text-center'>No se han encontrado registros</p>", 1);                
                if($total_rows > $pagerows) $pagina = ceil($total_rows / $pagerows);                 
                if($p && is_numeric($p)) $pagina = $p;                             
                if($s && is_numeric($s)) $desde = $s;               

                $last = ($pagina * $pagerows) - $pagerows;
	            $current_page = ($desde/$pagerows) + 1;
                
                
                /** Select all dishes from DB */

                $query = "SELECT * FROM dishes 
                        INNER JOIN dishes_day 
                        ON dishes.category_id = dishes_day.category_id
                        INNER JOIN dishes_menu
                        ON dishes.menu_id = dishes_menu.menu_id
                        ORDER BY dishes.dishe_id
                        LIMIT :desde, :pagerows";
                    
                $stm = $this->dbcon->pdo->prepare($query);
                $stm->bindValue(":desde", $desde); 
                $stm->bindValue(":pagerows", $pagerows);                                        
                $stm->execute();       
                $rows = $stm->fetchAll();
                $stm->closeCursor();

                include(SITE_ROOT . "/../view/admin/dishes/index_view.php");
            } 
            catch (\PDOException $e) {
                if ($_SESSION['role'] === "ROLE_ADMIN") {                   
                    $error_msg = "<p>Error en la ejecución.</p><p>Descripción del error: <span class='error'>{$e->getMessage()}</span></p>";

                    include(SITE_ROOT . "/../view/database_error.php");
                }
                else {
                    $error_msg = "<p class='alert alert-danger text-center'>{$h->getMessage()}</p>";					
                }
            }         
            catch (\Throwable $th) {
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
							de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
					include(SITE_ROOT . "/../view/database_error.php");	
            }
            
        }

        public function showForm(): void
        {                
            // We obtain all registries in "dishes" tables          
            $query = new Query($this->dbcon);
            $categoriesDishesDay = $query->selectAll("dishes_day", $this->dbcon);
            $categoriesDishesMenu = $query->selectAll("dishes_menu", $this->dbcon);

            include(SITE_ROOT . "/../view/admin/dishes/new_view.php");
        }

        /** Create new user */
        public function new(): void
        {
            // We obtain all registries in "dishes" tables           
            $query = new Query($this->dbcon);
            $categoriesDishesDay = $query->selectAll("dishes_day", $this->dbcon);
            $categoriesDishesMenu = $query->selectAll("dishes_menu", $this->dbcon);
            

            // Validate entries
            $validate = new Validate();

            $name = $validate->test_input($_REQUEST['name'] ?? "");
            $description = $validate->test_input($_REQUEST['description'] ?? "");
            $category = $validate->test_input($_REQUEST['category'] ?? "");
            $menu_id = $validate->test_input($_REQUEST['dishes_type'] ?? "");

            $fields = [
                "Name"          =>  $name, 
                "Description"   =>  $description, 
                "Category"      =>  $category,
                "Dishe type"    =>  $menu_id,
            ];

            $validateOk = $validate->validate_form($fields);
            
            try {
                if ($validateOk) {
                    $query = "INSERT INTO dishes (name, description, category_id, menu_id) VALUES (:name, :description, :category, :menu_id)";                 
    
                    $stm = $this->dbcon->pdo->prepare($query); 
                    $stm->bindValue(":name", $name);
                    $stm->bindValue(":description", $description);
                    $stm->bindValue(":category", $category); 
                    $stm->bindValue(":menu_id", $menu_id);             
                    $stm->execute();       				
                    $stm->closeCursor();                    
    
                    $success_msg = "<p class='alert alert-success text-center'>El nuevo plato se ha registrado correctamente</p>";                   
                    header("Location: /admin/admin_dishes.php?message={$success_msg}");										
                }
                else {
                    $error_msg = $validate->get_msg();
                    include(SITE_ROOT . "/../view/admin/dishes/new_view.php");                   
                }
            } catch (\Throwable $th) {			
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
                        de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");				
            }            		
        }

        public function show(): void
        {
            // We obtain all registries in "dishes" tables
            
            $query = new Query($this->dbcon);
            $categoriesDishesDay = $query->selectAll("dishes_day", $this->dbcon);
            $categoriesDishesMenu = $query->selectAll("dishes_menu", $this->dbcon);


            /** Get the id */

            $dishe_id = $_REQUEST['dishe_id'];                                  

            try {
                /** 
                 * We make inner joins to diferent tables to obtain the elements to show in "selects"
                 * elements in forms views 
                 * */ 

                $dishe = $query->selectOneByIdInnerjoinOnfield("dishes", "dishes_day", "category_id", "dishe_id", $dishe_id, $this->dbcon);
                $disheType = $query->selectOneByIdInnerjoinOnfield("dishes", "dishes_menu", "menu_id", "dishe_id", $dishe_id, $this->dbcon);

                include(SITE_ROOT . "/../view/admin/dishes/show_view.php");
                
            } catch (\Throwable $th) {
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
                    de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");					
            }	
        }

        /** Update dishe */
        public function update(): void
        {
            // Validate entries
            $validate = new Validate();          

            $fields = [
                "id" => $_REQUEST['dishe_id'] ?? "",
                "name" => $validate->test_input($_REQUEST['name'] ?? ""),
                "description" => $validate->test_input($_REQUEST['description'] ?? ""),
                "category_id" => $validate->test_input($_REQUEST['category'] ?? ""),
                "menu_id" => $validate->test_input($_REQUEST['dishes_type'] ?? ""),
            ];
           
            try {
                $query = new QueryMenu();
                $query->updateDishe($fields, $this->dbcon);

                $msg = "<p class='container alert alert-success text-center'>Registro actualizado correctamente</p>";
                
                header("Location: /admin/admin_dishes.php?message={$msg}");

            } catch (\Throwable $th) {			
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
                        de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");				
            }
        }        

        /** Deleting a user from the database. */
        public function delete(): void
        {
            $dishe = $_REQUEST['dishe_id'];
	
            try {
                $query = new Query($this->dbcon);
                $query->deleteRegistry("dishes", "dishe_id", $dishe, $this->dbcon);

                $success_msg = "<p class='alert alert-success text-center'>Se ha eliminado el registro</p>";

                include(SITE_ROOT . "/../view/database_error.php");

            } catch (\Throwable $th) {
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
                        de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");
            }
        }
    }    
?>