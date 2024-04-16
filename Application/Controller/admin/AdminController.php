<?php    
    declare(strict_types=1);

    use Application\Core\Controller;
    use model\classes\Language;
    use model\classes\Query;    
    use model\classes\Validate;

    class AdminController extends Controller
    {   
        /** Create array and object for diferent languages */
        private array $language = [];
        private Language $languageObject;

        public function __construct(
            private object $dbcon = DB_CON, 
            private string $message = "",             
        )
        {
            $this->languageObject = new Language(); 
            
            /** Configure page language */
            $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english(); 
        }

        /** Show main menus views */
        public function adminMenus(string $message = null):void
        {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            /** Test page language */
            $_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language']; 
            
            $error_msg = $message ?? "";
            
            include(SITE_ROOT . "/../Application/view/admin/admin_menus_view.php");
        }

        /** Show user index */
        public function index(): void
        {    
            /** Check for user`s sessions */                        
            $this->testAccess(['ROLE_ADMIN']);

            $query = new Query();
            $rows = $query->selectAllInnerjoinByField('user', 'roles', 'id_role', $this->dbcon);				                        
            $message = $this->message;

            include(SITE_ROOT . "/../Application/view/admin/index_view.php");
        }

        /** Create new user */
        public function new(): void
        {              
            /** Check for user`s sessions */            
            $this->testAccess(['ROLE_ADMIN']);

            $fields = [];
            $validate = new Validate();
            $query = new Query();                                

            try {
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $fields = [
                        'user_name' =>  $validate->test_input($_REQUEST['user_name']),
                        'password'  =>  $validate->test_input($_REQUEST['password']),
                        'email'     =>  $validate->test_input($_REQUEST['email'])
                    ];

                    if($validate->validate_form($fields)) {
                        $rows = $query->selectOneBy("user", "email", $fields['email'], $this->dbcon);                    

                        if($rows) {                                             
                            $this->message = "<p class='alert alert-danger text-center'>El email '{$fields['email']}' ya está registrado</p>";                                                 										
                        }
                        else {                            
                            $query->insertInto('user', $fields);                        
                                                                                                
                            $this->message = "<p class='alert alert-success text-center'>" . ucfirst($this->language['created_user']) . "</p>";                        
                            $this->index();
                            die;                      
                        }
                    }
                    else {
                        $this->message = $validate->get_msg();
                    }                                                                            										
                }
                
                include(SITE_ROOT . "/../Application/view/admin/user_new_view.php");
                                
            } catch (\Throwable $th) {			
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                include(SITE_ROOT . "/../Application/view/database_error.php");			
            }			
        }

        public function show(): void
        {   
            /** Check for user`s sessions */            
            $this->testAccess(['ROLE_ADMIN']);

            global $id;                        
	
            $query = new Query();

            try {                
                $user = $query->selectOneByIdInnerjoinOnfield('user', 'roles', 'id_role', 'id', $id, $this->dbcon);

                $fields = [
                    'user_name' => $user['user_name'],
                    'email'     => $user['email']
                ];
                
                $roles = $query->selectAll('roles');

                include(SITE_ROOT . "/../Application/view/admin/user_show_view.php");
                
            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                include(SITE_ROOT . "/../Application/view/database_error.php");				
            }	
        }

        /** Update user */
        public function update(): void
        {  
            /** Check for user`s sessions */            
            $this->testAccess(['ROLE_ADMIN']);

            global $id;

            try {
                /** We create the instances to objects */
                $validate = new Validate();
                $query = new Query();

                /** We get values from form */                
                $fields = [
                    'id'        => $validate->test_input($_REQUEST['id_user']),
                    'user_name' => $validate->test_input($_REQUEST['user_name']),                    
                    'email'     => $validate->test_input($_REQUEST['email']),
                    'id_role'   => $validate->test_input($_REQUEST['role']),
                ];

                /** Fix warnings when show the alert message on updating the user and we change the language */                
                if(empty($fields['id'])) {
                    $user = $query->selectOneBy("user", "id", $id, $this->dbcon);                    
                    
                    /** Setting properties */
                    $fields = [
                        'id'        => $user['id'],
                        'user_name' => $user['user_name'],                    
                        'email'     => $user['email'],
                        'id_role'   => $user['id_role'],
                    ];
                }                                

                if(!$validate->validate_form($fields)) {
                    $this->message = $validate->get_msg();
                    $this->show();
                    die;
                }
                
                /** Save data */
                $query->updateRegistry("user", $fields, 'id', $this->dbcon);
                $this->message = "<p class='alert alert-success text-center'>" . ucfirst($this->language['row_updated']) . "</p>";                                    
                $this->index();

            } catch (\Throwable $th) {			                                
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                include(SITE_ROOT . "/../Application/view/database_error.php");
            }
        }

        /** Change user password */
        public function changePassword(): void
        {
            /** Check for user`s sessions */            
            $this->testAccess(['ROLE_ADMIN']);

            global $id;            

            /** Build objects */
            $validate = new Validate();
            $query = new Query();            
                        
            try {
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $fields = [
                        'password'  =>  $validate->test_input($_REQUEST['password']),
                        'new_password'  =>  $validate->test_input($_REQUEST['new_password'])
                    ];

                    if($validate->validate_form($fields)) {
                        $id = $validate->test_input($_REQUEST['id_user'] ?? "");
                        if ($fields['password'] !== $fields['new_password']) {
                            $this->message = "<p class='alert alert-danger text-center'>" . ucfirst($this->language['password_not_equal']) . "</p>";
                        } else {                        
                            $query->updatePassword("user", $fields['new_password'], $id, $this->dbcon);
    
                            $this->message = "<p class='alert alert-success text-center'>" . ucfirst($this->language['password_updated']) . "</p>";
                        } 
                    }
                    else {
                        $this->message = $validate->get_msg();
                    }
                    
                }
                               
            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                include(SITE_ROOT . "/../Application/view/database_error.php");
            }

            include(SITE_ROOT . "/../Application/view/admin/user_change_password.php");
        }

        /** Deleting a user from the database. */
        public function delete(): void
        {
            /** Check for user`s sessions */            
            $this->testAccess(['ROLE_ADMIN']);
            
            $id_user = $_REQUEST['id_user'] ?? "";

            if(!isset($id_user)) $this->index();
	
            try {
                $query = new Query();
                $query->deleteRegistry("user", "id", $id_user, $this->dbcon);
                $this->message = "<p class='alert alert-success text-center'>" . ucfirst($this->language['delected_user']) . "</p>";
                $this->index();

            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                include(SITE_ROOT . "/../Application/view/database_error.php");
            }
        }
    }    
?>