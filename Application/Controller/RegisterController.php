<?php   
	declare(strict_types=1);

	use Application\Core\Controller;
	use model\classes\Language;
	use model\classes\Query;
	use model\classes\Validate;

    /**
     * register a new user in the database. 
     */
    class RegisterController extends Controller
    {        
		private Language $languageObject;		

        public function __construct(
			private array $fields = [],
			private string $message = "",
			private array $language = []
		)
        {            
			$this->languageObject = new Language();

			/** Configure page language */           
			$this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();
        }

        /* Register a new User */
        public function index(): void
        { 			
			/** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

			try {
				/** Test page language */
                $_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language']; 

				if($_SERVER['REQUEST_METHOD'] === 'POST') {	
					$validate = new Validate;					

					$this->fields = [
						'user_name' =>	isset($_REQUEST) ? $validate->test_input($_REQUEST['user_name']) : "",
						'password'	=>	isset($_REQUEST) ? $validate->test_input($_REQUEST['password']) : "",
						'email'		=>	isset($_REQUEST) ? $validate->test_input($_REQUEST['email']) : ""
					];

					if($validate->validate_form($this->fields)) {
						$query = new Query();
	
						$rows = $query->selectAllBy("user", "email", $this->fields['email']);
	
						if($rows) {
							$this->message = "<p class='alert alert-danger text-center'>" . ucfirst($this->language['email_registered']) . "</p>";																	
						}
						else {							
							$query->insertInto('user', $this->fields);              														
			
							$this->message = "<p class='alert alert-success text-center'>El usuario se ha registrado correctamente</p>";

							$this->render("/view/database_error.php", [
								'message'	=>	$this->message
							]);
						}
					}
					else {
						$this->message = "<p class'error text-center'>" . $validate->get_msg() . "</p>";
					}					
				}								
				
				$this->render("/view/register_view.php", [
					'message'	=>	$this->message,
					'fields'	=>	$this->fields
				]);

			} catch (\Throwable $th) {			
				$this->message = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
						de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
				
				if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
					$this->message = "<p class='alert alert-danger text-center'>
									Message: {$th->getMessage()}<br>
									Path: {$th->getFile()}<br>
									Line: {$th->getLine()}
								</p>";
				}
				
				$this->render("/view/database_error.php", [
					'message'	=>	$this->message
				]);
			}
        }
    }    
?>