<?php
    namespace Controller\admin;

    use model\classes\Query;    
    use model\classes\Validate;

    class AdminController
    {         
        public function __construct(private object $dbcon, private string $message = "")
        {

        }

        /** Show main menus views */
        public function adminMenus(string $message = null):void
        {
            $error_msg = $message ?? "";
            
            include(SITE_ROOT . "/../view/admin/admin_menus_view.php");
        }

        /** Show user index */
        public function index(): void
        {           
            $query = new Query();
            $rows = $query->selectAllInnerjoinByField('user', 'roles', 'id_role', $this->dbcon);				                        
            $message = $this->message;

            include(SITE_ROOT . "/../view/admin/index_view.php");
        }

        /** Create new user */
        public function new(): void
        {
            $user_name = $_REQUEST['user_name'] ?? "";
            $password = $_REQUEST['password'] ?? "";
            $email = $_REQUEST['email'] ?? "";

            try {
                if (!empty($user_name) && !empty($password) && !empty($email)) {
                    $query = new Query($this->dbcon);
                    $rows = $query->selectAllBy("user", "email", $email, $this->dbcon);

                    if ($rows) {
                        $error_msg = "<p class='error'>El email '{$email}' ya está registrado</p>";
                        include(SITE_ROOT . "/../view/admin/user_new_view.php");											
                    }
                    else {
                        $query = "INSERT INTO user (user_name, password, email) VALUES (:name, :password, :email)";                 
    
                        $stm = $this->dbcon->pdo->prepare($query); 
                        $stm->bindValue(":name", $user_name);
                        $stm->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
                        $stm->bindValue(":email", $email);              
                        $stm->execute();       				
                        $stm->closeCursor();                                                                         

                        $this->message = "<p class='alert alert-success text-center'>El usuario se ha registrado correctamente</p>"; 
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
            $id_user = $_REQUEST['id_user'];
	
            $query = new Query($this->dbcon);

            try {                
                $user = $query->selectOneByIdInnerjoinOnfield('user', 'roles', 'id_role', 'id_user', $id_user, $this->dbcon);
                $roles = $query->selectAll('roles', $this->dbcon);

                include(SITE_ROOT . "/../view/admin/user_show_view.php");
                
            } catch (\Throwable $th) {
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
                    de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");					
            }	
        }

        /** Update user */
        public function update(): void
        {            
            try {
                /** We create the instances to objects */
                $validate = new Validate();
                $query = new Query();


                /** We get values from form */
                $user_name = $validate->test_input($_REQUEST['user_name']) ?? "";
                $id_user = $validate->test_input($_REQUEST['id_user']) ?? "";
                ($validate->validate_email($_REQUEST['email'])) ? $email = $validate->test_input($_REQUEST['email']) : "";           
                $role = $validate->test_input($_REQUEST['role']) ?? "";


                /** Setting properties */
                $fields = [
                    'id_user'   => $id_user,
                    'user_name' => $user_name,                    
                    'email'     => $email,
                    'id_role'      => $role,
                ];

                $validate_ok = $validate->validate_form($fields);

                if(!$validate_ok) throw new \Exception($validate->get_msg(), 1);

                
                /** Save data */
                $query->updateRegistry("user", $fields, 'id_user', $this->dbcon);
                $this->message = "<p class='alert alert-success text-center'>Registro actualizado correctamente</p>";                                    
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
            $validate = new Validate();
	
            $password = $validate->test_input($_REQUEST['password'] ?? "");
            $id_user = $validate->test_input($_REQUEST['id_user'] ?? "");
            $newPassword = $validate->test_input($_REQUEST['new_password'] ?? "");

            try {
                if (!empty($password) && !empty($id_user) && !empty($newPassword)) {
                    if ($password !== $newPassword) {
                        $this->message = "<p class='alert alert-danger text-center'>Las contraseñas no son iguales</p>";
                    } else {
                        $query = new Query($this->dbcon);
                        $query->updatePassword("user", $newPassword, $id_user, $this->dbcon);

                        $this->message = "<p class='alert alert-success text-center'>Se ha cambiado la contraseña</p>";
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
            $id_user = $_REQUEST['id_user'];
	
            try {
                $query = new Query($this->dbcon);
                $query->deleteRegistry("user", "id_user", $id_user, $this->dbcon);
                $this->message = "<p class='alert alert-success text-center'>Se ha eliminado el registro</p>";
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