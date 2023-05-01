<?php
    namespace Controller\admin;

    use Exception;
    use model\classes\CommonTasks;
    use model\classes\Query;
    use model\classes\QueryMenu;
    use model\classes\Validate;    
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

                /** Variables to manage in view file */
                $action = "listado";
                $field = null;
                $commonTask = new CommonTasks();                          

                include(SITE_ROOT . "/../view/admin/dishes/index_view.php");
            } 
            catch (\PDOException $e) {
                if ($_SESSION['role'] === "ROLE_ADMIN") {                   
                    $message = $e->getMessage();                    
                }
                else {
                    $message = "<p class='alert alert-danger text-center'>{$h->getMessage()}</p>";					
                }

                include(SITE_ROOT . "/../view/admin/dishes/index_view.php");
            }         
            catch (\Throwable $th) {
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
							de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");	
            }            
        }

        public function showForm(): void
        {                            
            try {
                // We obtain all registries in "dishes" tables          
                $query = new Query($this->dbcon);
                $categoriesDishesDay = $query->selectAll("dishes_day", $this->dbcon);
                $categoriesDishesMenu = $query->selectAll("dishes_menu", $this->dbcon);

                include(SITE_ROOT . "/../view/admin/dishes/new_view.php");
                
            } catch (\PDOException $e) {
                if ($_SESSION['role'] === "ROLE_ADMIN") {                   
                    $error_msg = $e->getMessage();                    
                }
                else {
                    $error_msg = "<p class='alert alert-danger text-center'>{$h->getMessage()}</p>";					
                }

                include(SITE_ROOT . "/../view/admin/dishes/new_view.php");

            } catch (\Throwable $th) {
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
							de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");	
            }
        }

        /** Create new dish */
        public function new(): void
        {
            try {
                $upload_dir = SITE_ROOT . "/uploads/dishes_pics/";
                $image_fieldname = "dishe_img";


                /** Picture's data */
                $picture_name = trim($_FILES['dishe_img']['name']);
                $type = trim($_FILES['dishe_img']['type']);
                $size = trim($_FILES['dishe_img']['size']);
                $error = trim($_FILES['dishe_img']['error']);
                $temporal = trim($_FILES['dishe_img']['tmp_name']);


                /** Diferent options that we can have when upload files */
                $php_errors = array(	
                    1 => 'Tamaño máximo de archivo in php.ini excedido',
                    2 => 'Tamaño máximo de archivo en formulario HTML excedido',
                    3 => 'Sólo una parte del archivo fué subido',
                    4 => 'No se seleccionó ningún archivo para subir.')
                ;


                // We obtain all registries in "dishes" tables           
                $query = new Query($this->dbcon);
                $categoriesDishesDay = $query->selectAll("dishes_day", $this->dbcon);
                $categoriesDishesMenu = $query->selectAll("dishes_menu", $this->dbcon);
                

                // Validate entries
                $validate = new Validate();                           

                $fields = [
                    "Name"          =>  $validate->test_input($_REQUEST['name'] ?? ""), 
                    "Description"   =>  $validate->test_input($_REQUEST['description'] ?? ""), 
                    "Category"      =>  $validate->test_input($_REQUEST['category'] ?? ""),
                    "Dishe_type"    =>  $validate->test_input($_REQUEST['dishes_type'] ?? ""),
                    "Price"         =>  $validate->test_input($_REQUEST['price'] ?? 0),                    
                ];

                $validateOk = $validate->validate_form($fields);


                /** Begin transaction */
                $this->dbcon->pdo->beginTransaction();

                if($_FILES[$image_fieldname]['error'] != 0) {
                    throw new \Exception("Error Processing Request" . " " . $php_errors[$_FILES[$image_fieldname]['error']]);                                                                                
                }

                @is_uploaded_file($_FILES[$image_fieldname]['tmp_name'])
                        or throw new \Exception("Está intentando hacer algo incorrecto!.",
                        "Uploaded request: file named " . "'{$_FILES[$image_fieldname]['tmp_name']}'");
                
                @getimagesize($_FILES[$image_fieldname]['tmp_name']) or throw new \Exception("El archivo que " 
                    . "intenta subir no es un archivo válido", $_FILES[$image_fieldname]['name']
                    . " debe ser (*.gif, *.jpg, *.jpeg o *.png).");

                /** New name for the file to upload */
                $now = time();
                while (file_exists($upload_filename = $upload_dir . $now . '-' . $_FILES[$image_fieldname]['name'])) {
                    $now++;
                }

                if(strncmp($type, "image/", 6) == 0) {
                    @move_uploaded_file($_FILES[$image_fieldname]['tmp_name'], $upload_filename)
                                or throw new \Exception("Ha habido un problema al guardar el archivo en " .
                                "su ubicación permanente." .
                                "Posiblemente esté relacionado con los permisos en las carpetas " .
                                "de destino {$upload_filename}", 1);

            
                    /** Redimensionado de imágen */
                    $file_name = $upload_filename; // ruta al archivo del servidor							
                    $w = 600; // ancho para la nueva imagen
                    $h = 400; // alto para la nueva imagen

                            
                    // crea la imagen dependiendo del tipo (jpeg, jpg, png o gif)
                    $commonTask = new CommonTasks();
                    $original = $commonTask->createImageFromSource($file_name, $type);

        
                    // redimensiona la imagen
                    $final_image = $commonTask->resizeImage($original, $w, $h);

        
                    // reemplaza la imagen del servidor
                    ImagePNG($final_image, $file_name, 9);
                    ImageDestroy($original);
                    ImageDestroy($final_image);                	
                }
                else {
                    throw new Exception("El formato del archivo debe ser (jpeg, jpg, gif o png).");                    	
                }
            } catch (\Exception $e) {
                $error_msg = "<p>Descripción del error: <span class='error'>{$e->getMessage()}</span></p>";
                $this->dbcon->pdo->rollBack();
                include(SITE_ROOT . "/../view/database_error.php");
            }
            	            
            try {
                if ($validateOk) {
                    $query = "INSERT INTO dishes (name, description, category_id, menu_id, picture, price) 
                                VALUES (:name, :description, :category, :menu_id, :picture, :price)"; 
                                
                                        
                    /** Test price type, if isn't numeric delete picture from server and throw an exception*/
                    if(!is_numeric($fields['Price'])){
                        $commonTask->deletePicture($upload_filename);                        
                        throw new Exception("El campo 'Precio' debe ser numérico.");
                    }
    
                    $stm = $this->dbcon->pdo->prepare($query); 
                    $stm->bindValue(":name", $fields['Name']);
                    $stm->bindValue(":description", $fields['Description']);
                    $stm->bindValue(":category", $fields['Category']); 
                    $stm->bindValue(":menu_id", $fields['Dishe_type']);
                    $stm->bindValue(":picture", $upload_filename);
                    $stm->bindValue(":price", $fields['Price']);             
                    $stm->execute();       				
                    $stm->closeCursor();                    
                    
                    $this->dbcon->pdo->commit();

                    $success_msg = "<p class='alert alert-success text-center'>El nuevo plato se ha registrado correctamente</p>";                   
                    header("Location: /admin/admin_dishes.php?message={$success_msg}");										
                }
                else {
                    $error_msg = $validate->get_msg();
                    $this->dbcon->pdo->rollBack();

                    include(SITE_ROOT . "/../view/admin/dishes/new_view.php");                   
                }

            } catch (\Exception $e) {
                $error_msg = "<p class='alert alert-danger text-center'>{$e->getMessage()}</p>";                              
                $this->dbcon->pdo->rollBack();
                
                include(SITE_ROOT . "/../view/admin/dishes/new_view.php"); 

            } catch (\Throwable $th) {			
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
                        de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                $this->dbcon->pdo->rollBack();

                include(SITE_ROOT . "/../view/database_error.php");				
            }            		
        }

        public function edit(): void
        {                                             
            try {
                // We obtain all registries in "dishes_day" and "dishes_menu" tables
            
                $query = new Query();
                $categoriesDishesDay = $query->selectAll("dishes_day", $this->dbcon);
                $categoriesDishesMenu = $query->selectAll("dishes_menu", $this->dbcon);


                /** Get the id */

                $dishe_id = $_REQUEST['dishe_id']; 

                /** 
                 * We make inner joins to diferent tables to obtain the elements to show in "selects"
                 * elements in forms views 
                 * */ 

                $dishe = $query->selectOneByIdInnerjoinOnfield("dishes", "dishes_day", "category_id", "dishe_id", $dishe_id, $this->dbcon);
                $disheType = $query->selectOneByIdInnerjoinOnfield("dishes", "dishes_menu", "menu_id", "dishe_id", $dishe_id, $this->dbcon);
                
                /** Showing dishe_picture in show info */
                
                $commonTask = new CommonTasks();                
                $dishePicture = $commonTask->getWebPath($dishe['picture'] ?? $dishe['picture'] = "");                

                include(SITE_ROOT . "/../view/admin/dishes/edit_view.php");
                
            } catch (\PDOException $e) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                include(SITE_ROOT . "/../view/database_error.php");

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

        /** Update dishe */
        public function update(): void
        {
            /** If there is a picture to update */
            try {
                if ($_FILES['dishe_img']['name']) {                                     
                    $upload_dir = SITE_ROOT . "/uploads/dishes_pics/";
                    $image_fieldname = "dishe_img";                
    
                    /** Picture's data */
                    $picture_name = trim($_FILES['dishe_img']['name']);
                    $type = trim($_FILES['dishe_img']['type']);
                    $size = trim($_FILES['dishe_img']['size']);
                    $error = trim($_FILES['dishe_img']['error']);
                    $temporal = trim($_FILES['dishe_img']['tmp_name']);
                 
                    /** Diferent options that we can have when upload files */
                    $php_errors = array(	
                        1 => 'Tamaño máximo de archivo in php.ini excedido',
                        2 => 'Tamaño máximo de archivo en formulario HTML excedido',
                        3 => 'Sólo una parte del archivo fué subido',
                        4 => 'No se seleccionó ningún archivo para subir.')
                    ; 
                    
                    if($_FILES[$image_fieldname]['error'] != 0) {
                        throw new \Exception("Error Processing Request" . " " . $php_errors[$_FILES[$image_fieldname]['error']]);                                                                                
                    }
    
                    @is_uploaded_file($_FILES[$image_fieldname]['tmp_name'])
                            or throw new \Exception("Está intentando hacer algo incorrecto!.",
                            "Uploaded request: file named " . "'{$_FILES[$image_fieldname]['tmp_name']}'");
                    
                    @getimagesize($_FILES[$image_fieldname]['tmp_name']) or throw new \Exception("El archivo que " 
                    . "intenta subir no es un archivo válido", $_FILES[$image_fieldname]['name']
                    . " debe ser (*.gif, *.jpg, *.jpeg o *.png).");
    
                    /** New name for the file to upload */
                    $now = time();
                    while (file_exists($upload_filename = $upload_dir . $now . '-' . $_FILES[$image_fieldname]['name'])) {
                        $now++;
                    }                    
    
                    if(strncmp($type, "image/", 6) == 0) {
                        @move_uploaded_file($_FILES[$image_fieldname]['tmp_name'], $upload_filename)
                                    or throw new \Exception("Ha habido un problema al guardar el archivo en " .
                                    "su ubicación permanente." .
                                    "Posiblemente esté relacionado con los permisos en las carpetas " .
                                    "de destino {$upload_filename}", 1);
                
                        /** Redimensionado de imágen */
                        $file_name = $upload_filename; // ruta al archivo del servidor							
                        $w = 600; // ancho para la nueva imagen
                        $h = 400; // alto para la nueva imagen
                                
                        // crea la imagen dependiendo del tipo (jpeg, jpg, png o gif)
                        $commonTask = new CommonTasks();                        
                        $original = $commonTask->createImageFromSource($file_name, $type);
                      
                        // redimensiona la imagen
                        $final_image = $commonTask->resizeImage($original, $w, $h);
                    
                        // reemplaza la imagen del servidor
                        ImagePNG($final_image, $file_name, 9);
                        ImageDestroy($original);
                        ImageDestroy($final_image);                	
                    }
                    else {
                        throw new Exception("El formato del archivo debe ser (jpeg, jpg, gif o png).");	
                    }
                }                                                        
            } catch (\Exception $e) {
                $error_msg = "<p class='alert alert-danger text-center'>{$e->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$e->getMessage()}<br>
                                    Path: {$e->getFile()}<br>
                                    Line: {$e->getLine()}
                                </p>";
                }

                include(SITE_ROOT . "/../view/database_error.php");
            }            
           
            try {
                // Validate entries
                $validate = new Validate();
                $commonTask = new CommonTasks();         

                $fields = [
                    "id"            => $_REQUEST['dishe_id'] ?? "",
                    "name"          => $validate->test_input($_REQUEST['name'] ?? ""),
                    "description"   => $validate->test_input($_REQUEST['description'] ?? ""),
                    "category_id"   => $validate->test_input($_REQUEST['category'] ?? ""),
                    "menu_id"       => $validate->test_input($_REQUEST['dishes_type'] ?? ""),
                    "price"         => $validate->test_input($_REQUEST['price'] ?? ""),
                    "available"     => $validate->test_input($_REQUEST['available'] ?? "NO"),
                ];                                 

                $validateOk = $validate->validate_form($fields);                   

                if ($validateOk) {
                    $query = new QueryMenu();

                    /** Get the object to manage the picture in the DB  */
                    $dishe = $query->selectOneBy("dishes", "dishe_id", $fields['id'], $this->dbcon);

                    /** If there is a new image to upload, we add it to fields array and delete the old one*/
                    if(isset($final_image)) {
                        $commonTask->deletePicture($dishe['picture']);
                        $fields["picture"] = $file_name;
                    }
                    else {                        
                        $fields["picture"] = $dishe['picture'];
                    }

                    $query->updateDishe($fields, $this->dbcon);
                    $msg = "<p class='container alert alert-success text-center'>Registro actualizado correctamente</p>";
                    
                    header("Location: /admin/admin_dishes.php?message={$msg}");

                } else {
                    $error_msg = $validate->get_msg();
                    include(SITE_ROOT . "/../view/admin/dishes/edit_view.php");  
                }                                
            } catch (\Throwable $th) {			
                $error_msg = "<p>Archivo: {$th->getFile()}</p><p>Línea: {$th->getLine()}</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");				
            }
        }        

        /** Deleting a user from the database. */
        public function delete(): void
        {
            $dishe = $_REQUEST['dishe_id'];
	
            try {
                /** Create objects */
                $query = new Query($this->dbcon);
                $commonTask = new CommonTasks();

                /** Obtain dishe to delete */
                $dishe_to_delete = $query->selectOneBy("dishes", "dishe_id", $dishe, $this->dbcon);                                                              

                $commonTask->deletePicture($dishe_to_delete['picture']);
                $query->deleteRegistry("dishes", "dishe_id", $dishe, $this->dbcon);

                $success_msg = "<p class='alert alert-success text-center'>Se ha eliminado el registro</p>";

                include(SITE_ROOT . "/../view/database_error.php");

            } catch (\PDOException $e) {
                $error_msg = "<p class='alert alert-danger text-center'>{$e->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$e->getMessage()}<br>
                                    Path: {$e->getFile()}<br>
                                    Line: {$e->getLine()}
                                </p>";
                }

                include(SITE_ROOT . "/../view/database_error.php");

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

        /** Show search form */
        public function search(string $message = null, string $p = null, string $s = null): void
        {
            try {
                /** Validate entries */ 
                $validate = new Validate();
                
                $dishes = new QueryMenu();
                $categoriesDishesMenu = $dishes->selectAll("dishes_menu", $this->dbcon);

                $fields = [
                    "Campo"  =>  $validate->test_input($_REQUEST['field'] ?? ""), 
                    "Criterio"  =>  $validate->test_input($_REQUEST['critery'] ?? ""),                                  
                ];                

                if($fields['Campo'] !== "" && $fields['Criterio'] !== "") {                    
                    /** Test validation */
                    $validateOk = $validate->validate_form($fields);                    

                    if($validateOk) {
                        /** Calculate necesary pages for pagination */ 
                        $pagerows = 6; // Number of rows for page.
                        $desde = 0;                        

                        $rows = $dishes->selectDishesByCritery($fields['Campo'], $fields['Criterio'], $this->dbcon);

                        $total_rows = count($rows);                        
                        $pagina = 1;

                        if(!$total_rows) throw new PDOException("<p class='alert alert-danger text-center'>No se han encontrado registros</p>", 1);                
                        if($total_rows > $pagerows) $pagina = ceil($total_rows / $pagerows);                 
                        if($p && is_numeric($p)) $pagina = $p;                             
                        if($s && is_numeric($s)) $desde = $s;               

                        $last = ($pagina * $pagerows) - $pagerows;
                        $current_page = ($desde/$pagerows) + 1;
                          
                        /** Variables to manage in view file */
                        $action = "search";
                        $field = $fields['Campo'];
                        $critery = $fields['Criterio'];
                        $commonTask = new CommonTasks();

                        $rows = $dishes->selectDishesByPagination($desde, $pagerows, $field, $critery, $this->dbcon);                      
                        include(SITE_ROOT . "/../view/admin/dishes/index_view.php");
                    }
                    else {
                        $msg = $validate->get_msg();
                        throw new Exception($msg, 1);                    
                    }
                }
                else {
                    include(SITE_ROOT . "/../view/admin/dishes/search_view.php");
                }
                                
            } catch (\Exception $e) {
                $error_msg = "<p class='alert alert-danger text-center'>{$e->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$e->getMessage()}<br>
                                    Path: {$e->getFile()}<br>
                                    Line: {$e->getLine()}
                                </p>";
                }

                include(SITE_ROOT . "/../view/database_error.php");
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