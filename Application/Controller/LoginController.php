<?php
    declare(strict_types=1);

use GuzzleHttp\Psr7\Message;
use model\classes\Language;
	use model\classes\Validate;

    /**
     * A class that contains the methods to login and logout. 
     */
    class LoginController
    {       
		private Language $languageObject;
		

		public function __construct(
			private object $dbcon = DB_CON,
			private array $language = [],
			private string $message = ""
		)
        {
			$this->languageObject = new Language();  

			/** Configure page language */
            $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();        
        }
		
        
        /**
		 * The index function checks if a user is logged in, validates login form input, queries the
		 * database for user credentials, and sets session variables upon successful login.
		 * 
		 * @param array language Based on the provided code snippet, the `index` function is
		 * responsible for handling user login functionality. It checks if the user is already logged
		 * in by checking the existence of `['id_user']`. If not, it processes the login form
		 * submission, validates the form fields, queries the database
		 */
		public function index(array $language = null): void
        {
			if(!isset($_SESSION['role'])) {
                header("Location: /");	                
            }
			
			$fields = [];
			$validate = new Validate;			            			

			if(!isset($_SESSION['id_user'])) {	
				if($_SERVER['REQUEST_METHOD'] === 'POST') {
					// get values from the form
					$fields = [
						'email'	=>	$validate->test_input($_REQUEST['email']),
						'password'	=>	$validate->test_input($_REQUEST['password']),
					];

					if($validate->validate_form($fields)) {
						// hacemos la consulta a la DB				
						$query = "SELECT * FROM user INNER JOIN roles ON user.id_role = roles.id_role WHERE email = :val";

						try {
							$stm = $this->dbcon->pdo->prepare($query);
							$stm->bindValue(":val", $fields['email']);				
							$stm->execute();					

							// si encuentra el usuario en la DB
							if($stm->rowCount() == 1) {
								$result = $stm->fetch(PDO::FETCH_ASSOC);					
								
								// comprueba que la contraseña introducida coincide con la de la DB
								if(password_verify($fields['password'], $result['password'])) {												
									$_SESSION['id_user'] = $result['id'];						
									$_SESSION['user_name'] = $result['user_name'];
									$_SESSION['role'] = $result['role'];												
									$stm->closeCursor();
																	
									header("Location: /");							
								}
								else {
									$this->message = "<p class='alert alert-danger text-center'>" . ucfirst($this->language['alert_login']) . "</p>";															
								}			
							}
							else {		
								$this->message = "<p class='alert alert-danger text-center'>" . ucfirst($this->language['alert_login']) . "</p>";																		
							}
							
						} catch (\Throwable $th) {					
							$this->message = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
								de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
							include(SITE_ROOT . "/../Application/view/database_error.php");				
						}
					}
					else {
						$this->message = $validate->get_msg();
					}						
				}								
			}
			else {		
				header("Location: /");
			}			
			
			include(SITE_ROOT . "/../Application/view/login_view.php");	
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