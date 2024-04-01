<?php   
	declare(strict_types=1);

	use model\classes\Language;
	use model\classes\Query;
	use model\classes\Validate;

    /**
     * register a new user in the database. 
     */
    class RegisterController
    {        
		private Language $languageObject;
		private array $language = [];

        public function __construct(private object $dbcon = DB_CON)
        {            
			$this->languageObject = new Language();

			/** Configure page language */           
			$this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();
        }

        /* A method of the class `RegisterController` that is called when the user clicks on the
        register button. */
        public function index(): void
        { 			
			/** Check for user`s sessions */
            testAccess();

			try {
				/** Test page language */
                $_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language']; 

				if($_SERVER['REQUEST_METHOD'] === 'POST') {	
					$validate = new Validate;
					$fields = [];

					if($validate->validate_email($_REQUEST['email'])) {
						$fields = [
							'user_name' =>	$user_name = $validate->test_input($_REQUEST['user_name']) ?? "",
							'password'	=>	$password = $validate->test_input($_REQUEST['password']) ?? "",
							'email'		=>	$validate->test_input($_REQUEST['email'])
						];

						if($validate->validate_form($fields)) {
							$query = new Query();
		
							$rows = $query->selectAllBy("user", "email", $fields['email']);
		
							if($rows) {
								$error_msg = "<p class='error text-center'>" . ucfirst($this->language['email_registered']) . "</p>";																	
							}
							else {
								$query = "INSERT INTO user (user_name, password, email) VALUES (:name, :password, :email)";                 
			
								$stm = $this->dbcon->pdo->prepare($query); 
								$stm->bindValue(":name", $user_name);
								$stm->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
								$stm->bindValue(":email", $fields['email']);              
								$stm->execute();       				
								$stm->closeCursor();						
				
								$success_msg = "<p>El usuario se ha registrado correctamente</p>";
								include(SITE_ROOT . "/../view/database_error.php");
								die;
							}
						}
						else {
							$error_msg = "<p class'error text-center'>" . $validate->get_msg() . "</p>";
						}
					}
					else {
						$error_msg = "<p class='error text-center'>Enter a valid e-mail</p>";
					}					
				}								

				include(SITE_ROOT . "/../view/register_view.php");

			} catch (\Throwable $th) {			
				$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
						de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
				
				if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
					$error_msg = "<p class='alert alert-danger text-center'>
									Message: {$th->getMessage()}<br>
									Path: {$th->getFile()}<br>
									Line: {$th->getLine()}
								</p>";
				}
				
				include(SITE_ROOT . "/../view/database_error.php");
				exit();
			}
        }
    }    
?>