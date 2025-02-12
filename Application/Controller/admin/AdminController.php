<?php    
    declare(strict_types=1);

    namespace Application\Controller\admin;

    use Application\Core\Controller;
    use Application\model\classes\Language;
    use Application\model\classes\Query;    
    use Application\model\classes\Validate;

    class AdminController extends Controller
    {   
        /** Create array and object for diferent languages */
        private array $language = [];
        private Language $languageObject;

        public function __construct(            
            private string $message = "",
            private array $fields = [],
            private Query $query = new Query(),
            private Validate $validate = new Validate()            
        )
        {
            $this->languageObject = new Language(); 
            
            /** Configure page language */
            $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english(); 
        }

        /** Show main menus views */
        public function adminMenus(string $message = ""):void
        {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            /** Test page language */
            $_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language']; 
            
            $this->message = $message ?? "";
                
            $this->render("/view/admin/admin_menus_view.php", [
                'message' => $this->message
            ]);
        }

        /** Show user index */
        public function index(): void
        {    
            /** Check for user`s sessions */                        
            $this->testAccess(['ROLE_ADMIN']);
           
            $rows = $this->query->selectAllInnerjoinByField('user', 'roles', 'id_role');				                                    
            
            $this->render("/view/admin/index_view.php", [
                'rows' => $rows,
                'message' => $this->message
            ]);
        }

        /** Create new user */
        public function new(): void
        {              
            /** Check for user`s sessions */            
            $this->testAccess(['ROLE_ADMIN']);                                                                 

            try {
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->fields = [
                        'user_name' =>  $this->validate->test_input($_REQUEST['user_name']),
                        'password'  =>  $this->validate->test_input($_REQUEST['password']),
                        'email'     =>  $this->validate->test_input($_REQUEST['email'])
                    ];

                    if($this->validate->validate_form($this->fields)) {
                        $rows = $this->query->selectOneBy("user", "email", $this->fields['email']);                    

                        if($rows) {                                             
                            $this->message = "<p class='alert alert-danger text-center'>El email '{$this->fields['email']}' ya está registrado</p>";                                                 										
                        }
                        else {                            
                            $this->query->insertInto('user', $this->fields);                        
                                                                                                
                            $this->message = "<p class='alert alert-success text-center'>" . ucfirst($this->language['created_user']) . "</p>";                        
                            $this->index();
                            die;                      
                        }
                    }
                    else {
                        $this->message = $this->validate->get_msg();
                    }                                                                            										
                }
                                
                $this->render("/view/admin/user_new_view.php", [
                    'message' => $this->message,
                    'fields'  => $this->fields
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
                    'message' => $this->message
                ]);		
            }			
        }

        public function show(): void
        {   
            /** Check for user`s sessions */            
            $this->testAccess(['ROLE_ADMIN']);

            global $id;                        	            

            try {                
                $user = $this->query->selectOneByFieldNameInnerjoinOnfield('user', 'roles', 'id_role', 'id', $id);

                $this->fields = [
                    'user_name' => $user['user_name'],
                    'email'     => $user['email']
                ];
                
                $roles = $this->query->selectAll('roles');
                
                $this->render("/view/admin/user_show_view.php", [
                    'message' => $this->message,
                    'fields'  => $this->fields,
                    'roles'   => $roles,
                    'user'    => $user
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
                    'message' => $this->message
                ]);	
            }	
        }

        /** Update user */
        public function update(): void
        {  
            /** Check for user`s sessions */            
            $this->testAccess(['ROLE_ADMIN']);

            global $id;

            try {                             
                /** We get values from form */                
                $this->fields = [
                    'id'        => $this->validate->test_input($_REQUEST['id_user']),
                    'user_name' => $this->validate->test_input($_REQUEST['user_name']),                    
                    'email'     => $this->validate->test_input($_REQUEST['email']),
                    'id_role'   => $this->validate->test_input($_REQUEST['role']),
                ];

                /** Fix warnings when show the alert message on updating the user and we change the language */                
                if(empty($this->fields['id'])) {
                    $user = $this->query->selectOneBy("user", "id", $id);                    
                    
                    /** Setting properties */
                    $this->fields = [
                        'id'        => $user['id'],
                        'user_name' => $user['user_name'],                    
                        'email'     => $user['email'],
                        'id_role'   => $user['id_role'],
                    ];
                }                                

                if(!$this->validate->validate_form($this->fields)) {
                    $this->message = $this->validate->get_msg();
                    $this->show();
                    die;
                }
                
                /** Save data */
                $this->query->updateRegistry("user", $this->fields, 'id');
                $this->message = "<p class='alert alert-success text-center'>" . ucfirst($this->language['row_updated']) . "</p>";                                    
                $this->index();

            } catch (\Throwable $th) {			                                
                $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                //include(SITE_ROOT . "/../Application/view/database_error.php");
                $this->render("/view/database_error.php", [
                    'message' => $this->message
                ]);
            }
        }

        /** Change user password */
        public function changePassword(): void
        {
            /** Check for user`s sessions */            
            $this->testAccess(['ROLE_ADMIN']);

            global $id;                                         
                        
            try {
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->fields = [
                        'password'      =>  $this->validate->test_input($_REQUEST['password']),
                        'new_password'  =>  $this->validate->test_input($_REQUEST['new_password'])
                    ];

                    if($this->validate->validate_form($this->fields)) {
                        $id = $this->validate->test_input($_REQUEST['id_user'] ?? "");
                        if ($this->fields['password'] !== $this->fields['new_password']) {
                            $this->message = "<p class='alert alert-danger text-center'>" . ucfirst($this->language['password_not_equal']) . "</p>";
                        } else {                        
                            $this->query->updatePassword("user", $this->fields['new_password'], $id);    
                            $this->message = "<p class='alert alert-success text-center'>" . ucfirst($this->language['password_updated']) . "</p>";
                        } 
                    }
                    else {
                        $this->message = $this->validate->get_msg();
                    }                    
                }
                               
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
                    'message' => $this->message,                    
                ]);
            }
            
            $this->render("/view/admin/user_change_password.php", [
                'message' => $this->message,
                'id'      => $id,
                'fields'  => $this->fields
            ]);
        }

        /** Deleting a user from the database. */
        public function delete(): void
        {
            /** Check for user`s sessions */            
            $this->testAccess(['ROLE_ADMIN']);
            
            $id_user = $_REQUEST['id_user'] ?? "";

            if(!isset($id_user)) $this->index();
	
            try {               
                $this->query->deleteRegistry("user", "id", $id_user);
                $this->message = "<p class='alert alert-success text-center'>" . ucfirst($this->language['delected_user']) . "</p>";
                $this->index();

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
                    'message' => $this->message
                ]);
            }
        }
    }    
?>