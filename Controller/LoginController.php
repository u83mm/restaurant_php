<?php
    namespace Controller;

    use PDO;	

    /**
     * A class that contains the methods to login and logout. 
     */
    class LoginController
    {       
		public function __construct(private object $dbcon = DB_CON)
        {
                        
        }
		
        /* Checking if the user is logged in. If not, it checks if the email and password are not
        empty. If they are not empty, it checks if the email exists in the database. If it does, it
        checks if the password is correct. If it is, it sets the session variables and redirects to
        the home page. If the email does not exist, it displays an error message. If the password is
        incorrect, it displays an error message. If the email and password are empty, it displays
        the login form. */
        public function login(array $language = null): void
        {
			if(!isset($_SESSION['role'])) {
                header("Location: /");	
                die;
            }

            // recogemos los datos del formulario
			$email = $_REQUEST['email'] ?? "";
			$password = $_REQUEST['password'] ?? "";			

			if(!isset($_SESSION['id_user'])) {	
				if(!empty($email) && !empty($password)) {
					// hacemos la consulta a la DB				
					$query = "SELECT * FROM user INNER JOIN roles ON user.id_role = roles.id_role WHERE email = :val";

					try {
						$stm = $this->dbcon->pdo->prepare($query);
						$stm->bindValue(":val", $email);				
						$stm->execute();					

						// si encuentra el usuario en la DB
						if($stm->rowCount() == 1) {
							$result = $stm->fetch(PDO::FETCH_ASSOC);					
							
							// comprueba que la contraseña introducida coincide con la de la DB
							if(password_verify($password, $result['password'])) {												
								$_SESSION['id_user'] = $result['id'];						
								$_SESSION['user_name'] = $result['user_name'];
								$_SESSION['role'] = $result['role'];												
								$stm->closeCursor();
																
								header("Location: /");							
							}
							else {
								$error_msg = "<p class='alert alert-danger text-center'>" . ucfirst($language['alert_login']) . "</p>";							
								//include(SITE_ROOT . "/../view/login_view.php");
							}			
						}
						else {		
							$error_msg = "<p class='alert alert-danger text-center'>" . ucfirst($language['alert_login']) . "</p>";												
							//include(SITE_ROOT . "/../view/login_view.php");
						}

						//include(SITE_ROOT . "/../view/login_view.php");
						//return;
					} catch (\Throwable $th) {					
						$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
							de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
						include(SITE_ROOT . "/../view/database_error.php");				
					}	
				}									
			}
			else {		
				header("Location: /");
			}			
			
			include(SITE_ROOT . "/../view/login_view.php");	
        }

        /* Unsetting the session variables and destroying the session. */
        public function logout(): void
        {
            unset($_SESSION['id_user']);
			unset($_SESSION['user_name']);
			unset($_SESSION['role']);			
		  
			$_SESSION = array();
		  
			session_destroy();
			setcookie('PHPSESSID', "0", time() - 3600);		  			            

			header("Location: /");	
        }
    }    
?>