<?php
    namespace Controller\admin;

    use model\classes\Query;
    use model\classes\QueryMenuDay;
    use model\classes\Validate;
    use PDO;

    class DishesController
    {        
        public function __construct(private object $dbcon)
        {

        }      

        /** Show dishes index */
        public function index(): void
        {
            try {
                $query = "SELECT * FROM dishes INNER JOIN dishes_category ON dishes.category_id = dishes_category.category_id";
                    
                $stm = $this->dbcon->pdo->prepare($query);                                        
                $stm->execute();       
                $rows = $stm->fetchAll();
                $stm->closeCursor();                

                include(SITE_ROOT . "/../view/admin/dishes/index_view.php");

            } catch (\Throwable $th) {
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
							de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
					include(SITE_ROOT . "/../view/database_error.php");	
            }
            
        }

        /** Create new user */
        public function new(): void
        {
            // We obtain all registries in "dishes_category" table
            
            $query = new Query($this->dbcon);
            $categories = $query->selectAll("dishes_category");

            // Validate entries
            $validate = new Validate();

            $name = $validate->test_input($_REQUEST['name'] ?? "");
            $description = $validate->test_input($_REQUEST['description'] ?? "");
            $category = $validate->test_input($_REQUEST['category'] ?? "");
            
            try {
                if (!empty($name) && !empty($description) && !empty($category)) {
                    $query = "INSERT INTO dishes (name, description, category_id) VALUES (:name, :description, :category)";                 
    
                    $stm = $this->dbcon->pdo->prepare($query); 
                    $stm->bindValue(":name", $name);
                    $stm->bindValue(":description", $description);
                    $stm->bindValue(":category", $category);              
                    $stm->execute();       				
                    $stm->closeCursor();                    
    
                    $success_msg = "<p class='alert alert-success text-center'>El nuevo plato se ha registrado correctamente</p>";
                    include(SITE_ROOT . "/../view/database_error.php");										
                }
                else {
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
            // We obtain all registries in "dishes_category" table
            
            $query = new Query($this->dbcon);
            $categories = $query->selectAll("dishes_category");


            /** Get the id */

            $dishe_id = $_REQUEST['dishe_id'];                                  

            try {              
                $dishe = $query->selectOneByIdInnerjoinOnfield("dishes", "dishes_category", "category_id", "dishe_id", $dishe_id);

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

            $id = $_REQUEST['dishe_id'] ?? "";
            $name = $validate->test_input($_REQUEST['name'] ?? "");
            $description = $validate->test_input($_REQUEST['description'] ?? "");
            $category = $validate->test_input($_REQUEST['category'] ?? "");
           
            try {
                $query = new QueryMenuDay($this->dbcon);
                $query->updateDishe($name, $description, $category, $id);

                $success_msg = "<p class='alert alert-success text-center'>Registro actualizado correctamente</p>";

                include(SITE_ROOT . "/../view/database_error.php");

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
                $query->deleteRegistry("dishes", "dishe_id", $dishe);

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