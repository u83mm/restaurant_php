<?php
    //namespace Controller;

	use model\classes\Language;
	use model\classes\Query;    

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
            $user_name = $_REQUEST['user_name'] ?? "";
			$password = $_REQUEST['password'] ?? "";
			$email = $_REQUEST['email'] ?? "";

			try {
				/** Test page language */
                $_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language']; 
				
				if (!empty($user_name) && !empty($password) && !empty($email)) {
					$query = new Query();

					$rows = $query->selectAllBy("user", "email", $email);

					if ($rows) {
						$error_msg = "<p class='error text-center'>" . ucfirst($this->language['email_registered']) . "</p>";
						include(SITE_ROOT . "/../view/register_view.php");											
					}
					else {
						$query = "INSERT INTO user (user_name, password, email) VALUES (:name, :password, :email)";                 
	
						$stm = $this->dbcon->pdo->prepare($query); 
						$stm->bindValue(":name", $user_name);
						$stm->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
						$stm->bindValue(":email", $email);              
						$stm->execute();       				
						$stm->closeCursor();
						$this->dbcon = null;
		
						$success_msg = "<p>El usuario se ha registrado correctamente</p>";
						include(SITE_ROOT . "/../view/database_error.php");
					}										
				}
				else {
					include(SITE_ROOT . "/../view/register_view.php");	
				}
			} catch (\Throwable $th) {			
				$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
						de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
				include(SITE_ROOT . "/../view/database_error.php");
				exit();
			}
        }
    }    
?>