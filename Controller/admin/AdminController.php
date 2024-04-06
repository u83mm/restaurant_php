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
            $this->testAccess();

            /** Test page language */
            $_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language']; 
            
            $error_msg = $message ?? "";
            
            include(SITE_ROOT . "/../view/admin/admin_menus_view.php");
        }

        /** Show user index */
        public function index(): void
        {    
            /** Check for user`s sessions */                        
            $this->testAccess(['ROLE_ADMIN']);

            $query = new Query();
            $rows = $query->selectAllInnerjoinByField('user', 'roles', 'id_role', $this->dbcon);				                        
            $message = $this->message;

            include(SITE_ROOT . "/../view/admin/index_view.php");
        }

        /** Create new user */
        public function new(): void
        {              
            /** Check for user`s sessions */            
            $this->testAccess(['ROLE_ADMIN']);

            $validate = new Validate();
            $query = new Query();
            
            $user_name = $_REQUEST['user_name'] ?? "";                     
            $password = $_REQUEST['password'] ?? "";
            $email = $_REQUEST['email'] ?? "";            

            try {
                if(!empty($user_name) && !empty($password) && !empty($email)) {

                    /** Validate fields */
                    $user_name = $validate->test_input($user_name); 
                    $password = $validate->test_input($password);
                    $email = $validate->validate_email($email) ? $validate->test_input($email) : throw new \Exception("Email isn't in valid format", 1);                  

                    
                    $rows = $query->selectOneBy("user", "email", $email, $this->dbcon);                    

                    if($rows) {                                             
                        $this->message = "<p class='alert alert-danger text-center'>El email '{$email}' ya está registrado</p>";
                        include(SITE_ROOT . "/../view/admin/user_new_view.php");                       										
                    }
                    else {
                        $fields = [
                            'user_name' => $user_name,
                            'password'  => $password,
                            'email'     => $email,
                        ];

                        $query->insertInto('user', $fields, $this->dbcon);                        
                                                                                               
                        $this->message = "<p class='alert alert-success text-center'>" . ucfirst($this->language['created_user']) . "</p>";                        
                        $this->index();                       
                    }										
                }
                else {
                    include(SITE_ROOT . "/../view/admin/user_new_view.php");
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

                include(SITE_ROOT . "/../view/database_error.php");			
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
                $roles = $query->selectAll('roles');

                include(SITE_ROOT . "/../view/admin/user_show_view.php");
                
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
                $user_name = isset($_REQUEST['user_name']) ? $validate->test_input($_REQUEST['user_name']) : "";
                $id_user = isset($_REQUEST['id_user']) ? $validate->test_input($_REQUEST['id_user']) : ""; 
                $email = isset($_REQUEST['email']) && $validate->validate_email($_REQUEST['email']) ? $validate->test_input($_REQUEST['email']) : "";                            ;                          
                $role = isset($_REQUEST['role']) ? $validate->test_input($_REQUEST['role']) : "";

                /** Fix warnings when show the alert message on updating the user and we change the language */                
                if(empty($id_user)) {
                    $user = $query->selectOneBy("user", "id", $id, $this->dbcon);
                    $user_name = $user['user_name'];
                    $id_user = $user['id'];
                    $email = $user['email'];
                    $role = $user['id_role'];                    
                }                                
                                
                /** Setting properties */
                $fields = [
                    'id'        => $id_user,
                    'user_name' => $user_name,                    
                    'email'     => $email,
                    'id_role'   => $role,
                ];

                $validate_ok = $validate->validate_form($fields);

                if(!$validate_ok) throw new \Exception($validate->get_msg(), 1);

                
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

                include(SITE_ROOT . "/../view/database_error.php");
            }
        }

        /** Change user password */
        public function changePassword(): void
        {
            /** Check for user`s sessions */            
            $this->testAccess(['ROLE_ADMIN']);

            global $id;            

            $validate = new Validate();
            $query = new Query();
	
            /** We get values from the form*/
            $password = $validate->test_input($_REQUEST['password'] ?? "");            
            $newPassword = $validate->test_input($_REQUEST['new_password'] ?? "");            

            try {
                if(!empty($password) && !empty($newPassword)) {
                    $id = $validate->test_input($_REQUEST['id_user'] ?? "");
                    if ($password !== $newPassword) {
                        $this->message = "<p class='alert alert-danger text-center'>" . ucfirst($this->language['password_not_equal']) . "</p>";
                    } else {                        
                        $query->updatePassword("user", $newPassword, $id, $this->dbcon);

                        $this->message = "<p class='alert alert-success text-center'>" . ucfirst($this->language['password_updated']) . "</p>";
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

                include(SITE_ROOT . "/../view/database_error.php");
            }

            include(SITE_ROOT . "/../view/admin/user_change_password.php");
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

                include(SITE_ROOT . "/../view/database_error.php");
            }
        }
    }    
?>