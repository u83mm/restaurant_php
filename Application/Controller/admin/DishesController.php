<?php   
    declare(strict_types=1);

    namespace Application\Controller\admin;

    use Application\Core\Controller;
    use Application\model\classes\CommonTasks;
    use Application\model\classes\Dishe;
    use Application\model\classes\Language;    
    use Application\model\classes\QueryMenu;
    use Application\model\classes\Validate;
    use Application\model\repositories\dishe\DishRepository;

    class DishesController extends Controller
    {        
        private Language $languageObject;

        public function __construct(
            private object $dbcon = DB_CON, 
            private array $language = [],
            private string $message = "",
            private array $fields = [],
            private QueryMenu $query = new QueryMenu(),
            private CommonTasks $commonTask = new CommonTasks(),
            private Validate $validate = new Validate(),
            private DishRepository $dishRepository = new DishRepository(),            
        )      
        {            
            /** Configure page language */
            $this->languageObject = new Language();
            $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();                        
        }    

        /** Show dishes index */
        public function index(): void
        {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);                 
            
            $p = $_POST['p'] ?? $_GET['p'] ?? $p = null;
	        $s = $_POST['s'] ?? $_GET['s'] ?? $s = null;

            try {                                
                /** Calculate necesary pages for pagination */ 
                $pagerows = RECORDS_PER_PAGE; // Number of rows per page.
                $desde = 0;                

                $total_rows = $this->query->selectCount('dishes');
                $pagina = 1;

                if(!$total_rows) $this->message = "<p class='alert alert-warning text-center'>" . ucfirst($this->language['rows_not_found']) . "</p>";    
                if($total_rows > $pagerows) $pagina = ceil($total_rows / $pagerows);                 
                if($p && is_numeric($p)) $pagina = (int) $p;                             
                if($s && is_numeric($s)) $desde = (int) $s;               

                $last = ($pagina * $pagerows) - $pagerows;
	            $current_page = ($desde/$pagerows) + 1;
                
                
                /** Select all dishes from DB */
                $rows = $this->dishRepository->selectAllDishes($desde, $pagerows);                                

                /** Variables to manage in view file */                
                $field = null;                
                $critery = "";                          

                /** Render view file */
                $this->render("/view/admin/dishes/index_view.php", [
                    "rows"          => $rows,
                    "pagina"        => $pagina,
                    "desde"         => $desde,                    
                    "field"         => $field,
                    "critery"       => $critery,                                        
                    "pagerows"      => $pagerows,
                    "current_page"  => $current_page,
                    "last"          => $last,
                    "total_rows"    => $total_rows,
                    "message"       => $this->message,
                    "commonTask"    => $this->commonTask
                ]);                
            }                      
            catch (\Throwable $th) {
                $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                } 
                
                $this->render("/view/database_error.php", [
                    "message" => $this->message
                ]);
            }            
        }

        public function showForm(): void
        {  
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);
            
            unset($_SESSION['action']);

            try {
                // We obtain all registries in "dishes" tables                          
                $categoriesDishesDay = $this->query->selectAll("dishes_day");
                $categoriesDishesMenu = $this->query->selectAll("dishes_menu");
                
                
                $this->render("/view/admin/dishes/new_view.php", [
                    "categoriesDishesDay" => $categoriesDishesDay,
                    "categoriesDishesMenu" => $categoriesDishesMenu
                ]);
                
            } catch (\Throwable $th) {
                $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                } 
                
                $this->render("/view/database_error", [
                    "message" => $this->message
                ]);	
            }
        }

        /** Create new dish */
        public function new(): void
        {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);  
            
            /** Test for session to stop the method when change language */
            if(isset($_SESSION['action'])) {
                $this->index();
                die;
            }

            try {
                $upload_dir = SITE_ROOT . "/uploads/dishes_pics/";
                $image_fieldname = "dishe_img";


                /** Picture's data */
                $picture_name = trim($_FILES['dishe_img']['name']);
                $type = trim($_FILES['dishe_img']['type']);
                $size = $_FILES['dishe_img']['size'];
                $error = $_FILES['dishe_img']['error'];
                $temporal = trim($_FILES['dishe_img']['tmp_name']);


                /** Diferent options that we can have when upload files */
                $php_errors = array(	
                    1 => 'Tamaño máximo de archivo in php.ini excedido',
                    2 => 'Tamaño máximo de archivo en formulario HTML excedido',
                    3 => 'Sólo una parte del archivo fué subido',
                    4 => 'No se seleccionó ningún archivo para subir.')
                ;


                // We obtain all registries in "dishes" tables                           
                $categoriesDishesDay = $this->query->selectAll("dishes_day");
                $categoriesDishesMenu = $this->query->selectAll("dishes_menu");
                

                // Validate entries                                                            
                $this->fields = [
                    "name"        =>  $this->validate->test_input($_REQUEST['name'] ?? ""), 
                    "description" =>  $this->validate->test_input($_REQUEST['description'] ?? ""), 
                    "category_id" =>  $this->validate->test_input(intval($_REQUEST['category']) ?? ""),
                    "menu_id"     =>  $this->validate->test_input(intval($_REQUEST['dishes_type']) ?? ""),
                    "price"       =>  $this->validate->test_input($_REQUEST['price'] ?? 0),                    
                ];  
                
                
                /** Begin transaction */
                $this->dbcon->pdo->beginTransaction();

                if($_FILES[$image_fieldname]['error'] != 0) {
                    throw new \Exception("Error Processing Request" . " " . $php_errors[$_FILES[$image_fieldname]['error']]);                                                                                
                }

                @is_uploaded_file($_FILES[$image_fieldname]['tmp_name'])
                        or throw new \Exception("Está intentando hacer algo incorrecto!." .
                        "Uploaded request: file named " . "'{$_FILES[$image_fieldname]['tmp_name']}'");
                
                @getimagesize($_FILES[$image_fieldname]['tmp_name']) or throw new \Exception("El archivo que " . 
                    "intenta subir no es un archivo válido" . $_FILES[$image_fieldname]['name'] .
                    " debe ser (*.gif, *.jpg, *.jpeg o *.png).");

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
                    $original = $this->commonTask->createImageFromSource($file_name, $type);

        
                    // redimensiona la imagen
                    $final_image = $this->commonTask->resizeImage($original, $w, $h);

        
                    // reemplaza la imagen del servidor
                    ImagePNG($final_image, $file_name, 9);
                    ImageDestroy($original);
                    ImageDestroy($final_image);                	
                }
                else {
                    throw new \Exception("El formato del archivo debe ser (jpeg, jpg, gif o png).");                    	
                }
            } catch (\Exception $e) {
                $this->message = "<p>Descripción del error: <span class='error'>{$e->getMessage()}</span></p>";
                $this->dbcon->pdo->rollBack();                
                
                /** Render error view */
                $this->render("/view/database_error.php", [
                    "message" => $this->message
                ]);
            }
            	            
            try {
                if($this->validate->validate_form($this->fields)) {                                                                                             
                    /** Test price type, if isn't numeric delete picture from server and throw an exception */
                    if(!is_numeric($this->fields['price'])){
                        $this->commonTask->deletePicture($upload_filename);                        
                        throw new \Exception("El campo 'Precio' debe ser numérico.");
                    }

                    /** Set picture path and dish id */
                    $this->fields['picture'] = $upload_filename;
                    $this->fields['dishe_id'] = $this->query->selectCount("dishes") + 1;
                    
                    /** Create new dish object */
                    $dishe = new Dishe($this->fields);                    
                    
                    /** Insert dish into database */
                    $this->query->insertInto("dishes", $dishe);                                        

                    $this->query->insertInto("dinamic_data", [
                        "dishe_id"                            => $dishe->getDisheId(),
                        "{$_SESSION['language']}_name"        => $this->fields['name'],
                        "{$_SESSION['language']}_description" => $this->fields['description']
                    ]);
                    
                    $this->dbcon->pdo->commit();

                    $this->message = "<p class='alert alert-success text-center'>El nuevo plato se ha registrado correctamente</p>";
                    $_SESSION['action'] = "skip_method";                
                    $this->index();                   								
                }
                else {
                    $this->message = $this->validate->get_msg();
                    $this->dbcon->pdo->rollBack();
                                
                    $this->render("/view/admin/dishes/new_view.php", [
                        "message"              => $this->message,
                        "categoriesDishesDay"  => $categoriesDishesDay,
                        "categoriesDishesMenu" => $categoriesDishesMenu,
                        "fields"               => $this->fields
                    ]);                   
                }

            } catch (\Exception $e) {
                $this->message = "<p class='alert alert-danger text-center'>{$e->getMessage()}</p>";                              
                $this->dbcon->pdo->rollBack();
                                 
                $this->render("/view/admin/dishes/new_view.php", [
                    "message"              => $this->message,
                    "categoriesDishesDay"  => $categoriesDishesDay,
                    "categoriesDishesMenu" => $categoriesDishesMenu,
                    "fields"               => $this->fields
                ]);

            } catch (\Throwable $th) {			
                $this->message = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
                        de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                $this->dbcon->pdo->rollBack();
                
                $this->render("/view/database_error.php", [
                    "message" => $this->message
                ]);				
            }            		
        }

        public function edit(): void
        {  
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']); 
            
            global $id;

            try {
                // We obtain all registries in "dishes_day" and "dishes_menu" tables                           
                $categoriesDishesDay = $this->query->selectAll("dishes_day");
                $categoriesDishesMenu = $this->query->selectAllOrderByFieldWhereFieldIsNotNull("dishes_menu", "{$_SESSION['language']}_menu_category");


                /** Get the id */
                $dishe_id = $id;                                                                             

                /** 
                 * We make inner joins to diferent tables to obtain the elements to show in "selects"
                 * elements in forms views 
                 * */ 

                //$dishe = $this->query->selectOneByFieldNameInnerjoinOnfield("dishes", "dishes_day", "category_id", "dishe_id", $dishe_id);
                $dishe = $this->dishRepository->selectDisheById($dishe_id);                
                $disheType = $this->query->selectOneByFieldNameInnerjoinOnfield("dishes", "dishes_menu", "menu_id", "dishe_id", $dishe_id);
                
                /** Showing dishe_picture in show info */                                                
                $dishePicture = $this->commonTask->getWebPath($dishe['picture'] ?? $dishe['picture'] = "");                                

                $this->render("/view/admin/dishes/edit_view.php", [
                    "message"              => $this->message,
                    "categoriesDishesDay"  => $categoriesDishesDay,
                    "categoriesDishesMenu" => $categoriesDishesMenu,
                    "dishe"                => $dishe,
                    "disheType"            => $disheType,
                    "dishePicture"         => $dishePicture
                ]);
                
            } catch (\PDOException $e) {
                $this->message = "<p class='alert alert-danger text-center'>{$e->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$e->getMessage()}<br>
                                    Path: {$e->getFile()}<br>
                                    Line: {$e->getLine()}
                                </p>";
                }
                
                $this->render("/view/database_error.php", [
                    "message" => $this->message
                ]);

            } catch (\Throwable $th) {
                $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }
                
                $this->render("/view/database_error.php", [
                    "message" => $this->message
                ]);				
            }	
        }

        /** Update dishe */
        public function update(): void
        {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            global $id;

            /** If there is a picture to update */
            try {
                if ($_FILES['dishe_img']['name']) {                                     
                    $upload_dir = SITE_ROOT . "/uploads/dishes_pics/";
                    $image_fieldname = "dishe_img";                
    
                    /** Picture's data */
                    $picture_name = trim($_FILES['dishe_img']['name']);
                    $type = trim($_FILES['dishe_img']['type']);
                    $size = $_FILES['dishe_img']['size'];
                    $error = $_FILES['dishe_img']['error'];
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
                            or throw new \Exception("Está intentando hacer algo incorrecto!." .
                            "Uploaded request: file named " . "'{$_FILES[$image_fieldname]['tmp_name']}'");
                    
                    @getimagesize($_FILES[$image_fieldname]['tmp_name']) or throw new \Exception("El archivo que " .
                    "intenta subir no es un archivo válido" . $_FILES[$image_fieldname]['name'] .
                    " debe ser (*.gif, *.jpg, *.jpeg o *.png).");
    
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

                        /** Redimensionado de imagen */
                        $file_name = $upload_filename; // ruta al archivo del servidor							
                        $w = 600; // ancho para la nueva imagen
                        $h = 400; // alto para la nueva imagen
                                
                        // crea la imagen dependiendo del tipo (jpeg, jpg, png o gif)                                           
                        $original = $this->commonTask->createImageFromSource($file_name, $type);                        
                
                        // redimensiona la imagen
                        $final_image = $this->commonTask->resizeImage($original, $w, $h);
                    
                        // reemplaza la imagen del servidor
                        ImagePNG($final_image, $file_name, 9);
                        ImageDestroy($original);
                        ImageDestroy($final_image);                	
                    }
                    else {
                        throw new \Exception("El formato del archivo debe ser (jpeg, jpg, gif o png).");	
                    }
                }                                                        
            } catch (\Exception $e) {
                $this->message = "<p class='alert alert-danger text-center'>{$e->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$e->getMessage()}<br>
                                    Path: {$e->getFile()}<br>
                                    Line: {$e->getLine()}
                                </p>";
                }
                
                $this->render("/view/database_error.php", [
                    "message" => $this->message
                ]);
            }            
           
            try {                              
                // Validate entries                                                    
                $this->fields = [
                    "dishe_id"    => $_REQUEST['dishe_id'] ?? $id ?? "",
                    "name"        => $this->validate->test_input($_REQUEST['name'] ?? ""),
                    "description" => $this->validate->test_input($_REQUEST['description'] ?? ""),
                    "category_id" => $this->validate->test_input($_REQUEST['category'] ?? ""),
                    "menu_id"     => $this->validate->test_input($_REQUEST['dishes_type'] ?? ""),
                    "price"       => $this->validate->test_input($_REQUEST['price'] ?? ""),
                    "available"   => isset($_REQUEST['available']) ? intval($_REQUEST['available']) : 0
                ];                                                                   

                if ($this->validate->validate_form($this->fields)) {                                         
                    /** Get the object to manage the picture in the DB  */
                    $dishe = $this->dishRepository->selectDisheById($id);

                    /** If there is a new image to upload, we add it to fields array and delete the old one*/
                    if(isset($final_image)) {
                        $this->commonTask->deletePicture($dishe['picture']);
                        $this->fields["picture"] = $file_name;
                    }
                    else {                        
                        $this->fields["picture"] = $dishe['picture'];
                    }

                    $this->dishRepository->updateDishe($this->fields);
                    $this->message = "<p class='container alert alert-success text-center'>" . ucfirst($this->language['row_updated']) . "</p>";
                    
                    $_SESSION['message'] = $this->message;
                    
                    header("Location: /admin/dishes/index");                    

                } else {
                    $this->message = $this->validate->get_msg();
                    
                    $this->render("/view/admin/dishes/edit_view.php", [
                        "message" => $this->message
                    ]);
                }                                
            } catch (\Throwable $th) {			
                $this->message = "<p>{$this->language['file']}: {$th->getFile()}</p>
                                  <p>{$this->language['line']}: {$th->getLine()}</p>
                                  <p>{$this->language['error_description']}: <span class='error'>{$th->getMessage()}</span></p>";
                
                $this->render("/view/database_error.php", [
                    "message" => $this->message
                ]);				
            }
        }        

        /** Deleting a dish from the database. */
        public function delete(): void
        {
            global $id;

            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            $dishe = $_REQUEST['dishe_id'] ?? "";

            if(!isset($dishe)) $this->index();
	
            try {                                          
                /** Obtain dishe to delete */
                $dishe_to_delete = $this->query->selectOneBy("dishes", "dishe_id", $dishe);
                
                if($dishe_to_delete) {
                    $this->dbcon->pdo->beginTransaction();
                    $this->commonTask->deletePicture($dishe_to_delete['picture']);
                    $this->query->deleteRegistry("dishes", "dishe_id", $dishe);
                    $this->query->deleteRegistry("dinamic_data", "dishe_id", $dishe);
                    $this->dbcon->pdo->commit();
    
                    $this->message = "<p class='alert alert-success text-center'>Se ha eliminado el registro</p>";                                         
                }
                
                $this->index();                

            } catch (\PDOException $e) {
                $this->message = "<p class='alert alert-danger text-center'>{$e->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$e->getMessage()}<br>
                                    Path: {$e->getFile()}<br>
                                    Line: {$e->getLine()}
                                </p>";
                }                

                $this->render("/view/database_error.php", [
                    "message" => $this->message
                ]);

            } catch (\Throwable $th) {
                $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }                

                $this->render("/view/database_error.php", [
                    "message" => $this->message
                ]);
            }
        }

        /** Show search form */
        public function search(string $message = null, ?string $p = null, ?string $s = null): void
        {            
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);            
            
            try {
                $p = $_POST['p'] ?? $_GET['p'] ?? $p = null;
	            $s = $_POST['s'] ?? $_GET['s'] ?? $s = null;                

                /** Validate entries */                                                 
                $categoriesDishesMenu = $this->query->selectAllOrderByFieldWhereFieldIsNotNull("dishes_menu", "{$_SESSION['language']}_menu_category");

                if($_SERVER['REQUEST_METHOD'] === 'POST') {                    
                    // Manage form data
                    //if(!isset($_REQUEST['field']) || !isset($_REQUEST['critery']) || empty($_REQUEST['critery'])) header("Location: /admin/dishes/search");

                    match ($_REQUEST['field']) {
                        'available' => $critery = isset($_REQUEST['critery']) ? intval($_REQUEST['critery']) : 0,
                        'name'      => $critery = $this->validate->test_input($_REQUEST['critery'] ?? ""),
                        'menu_id'   => $critery = $this->validate->test_input($_REQUEST['critery'] ?? ""),
                        'default'   => $critery = $this->validate->test_input($_REQUEST['critery'] ?? ""),
                    };

                    $this->fields = [
                        "Campo"     =>  $this->validate->test_input($_REQUEST['field'] ?? ""), 
                        "Criterio"  =>  $critery ?? "",                                  
                    ];                    

                    /** Test validation search form by name*/
                    if(!$this->validate->validate_form($this->fields) && $this->fields['Campo'] === 'name') {
                        $this->message = "<p class='alert alert-danger text-center'>" . ucfirst($this->language['enter_valid_data']) .  "</p>";
                        $this->render("/view/admin/dishes/search_view.php", [
                            "error_by_name" => $this->message
                        ]);
                    }                                                                                                
                    
                    /** Validate form */
                    if($this->validate->validate_form($this->fields)) {                                                
                        /** Calculate necesary pages for pagination */ 
                        $pagerows = RECORDS_PER_PAGE; // Number of rows for page.
                        $desde = 0;                        

                        /** Select method to do the search */
                        match($this->fields['Campo']) {
                            default   => $rows = $this->query->selectDishesLikeCritery($this->fields['Campo'], $this->fields['Criterio']),
                            'menu_id' => $rows = $this->query->selectDishesByCritery($this->fields['Campo'], $this->fields['Criterio']),  
                        };                                                 
                                                
                        $total_rows = count($rows);                        
                        $pagina = 1;                        

                        if(!$total_rows) {
                            $this->message = "<p class='alert alert-warning text-center'>" . ucfirst($this->language['rows_not_found']) . "</p>";
                            $this->render("/view/admin/dishes/index_view.php", [                                                                                                                                                                             
                                "pagina"  => $pagina,                                                                                                                                                      
                                "message" => $this->message,                                                                
                            ]);
                        }                                        
                        elseif($total_rows > $pagerows) $pagina = ceil($total_rows / $pagerows); 
                                        
                        if($p && is_numeric($p)) $pagina = $p;                             
                        if($s && is_numeric($s)) $desde = $s;                                                

                        $last = ($pagina * $pagerows) - $pagerows;
                        $current_page = ($desde/$pagerows) + 1;                                             
                            
                        /** Variables to manage in view file */                       
                        $field = $this->fields['Campo'];
                        $critery = $this->fields['Criterio'];                                        

                        if($total_rows >= 6) {
                            /** Select method to do the search */
                            match($this->fields['Campo']) {
                                'available' =>  $rows = $this->query->selectDishesLikePagination(intval($desde), $pagerows, $field, $critery),
                                'menu_id'   =>  $rows = $this->query->selectDishesByPagination(intval($desde), $pagerows, $field, $critery),
                            };
                        }                                                                                            

                        /** Show dishes index */
                        $this->render("/view/admin/dishes/index_view.php", [
                            "rows"         => $rows,                                                        
                            "field"        => $field,
                            "critery"      => $critery,
                            "current_page" => $current_page,                                                       
                            "pagina"       => $pagina,
                            "desde"        => $desde,                                                                            
                            "pagerows"     => $pagerows,                            
                            "last"         => $last, 
                            "total_rows"   => $total_rows,                           
                            "message"      => $this->message,
                            "commonTask"   => $this->commonTask,                           
                        ]);                                                 
                    }
                    else {                        
                        throw new \Exception($this->validate->get_msg(), 1);                    
                    }                    
                }                
                
                /** Show search form */                    
                $this->render("/view/admin/dishes/search_view.php", [
                    "categoriesDishesMenu"  => $categoriesDishesMenu,
                ]);
                                
            } catch (\Exception $e) {
                $this->message = "<p class='alert alert-danger text-center'>{}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$e->getMessage()}<br>
                                    Path: {$e->getFile()}<br>
                                    Line: {$e->getLine()}
                                </p>";
                }                

                $this->render("/view/database_error.php", [
                    "message" => $this->message
                ]);

            } catch (\Throwable $th) {			
                $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }
                
                $this->render("/view/database_error.php", [
                    "message" => $this->message
                ]);			
            }             
        }
    }    
?>