<?php   
	declare(strict_types=1);

	namespace Application\Controller;

	use Application\Core\Controller;
	use Application\model\classes\Language;
	use Application\model\classes\Query;
	use Application\model\classes\User;
	use Application\model\classes\Validate;
	use Application\model\repositories\UserRepository;

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

			$validate = new Validate;

			try {
				/** Test page language */
                $_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language']; 

				if($_SERVER['REQUEST_METHOD'] === 'POST') {	
					if(isset($_REQUEST['user_name'], $_REQUEST['password'], $_REQUEST['email'])) {
						$this->fields = [
							'name' 		=>	isset($_REQUEST) ? $validate->test_input($_REQUEST['user_name']) : "",
							'password'	=>	isset($_REQUEST) ? $validate->test_input($_REQUEST['password']) : "",
							'email'		=>	isset($_REQUEST) ? $validate->test_input($_REQUEST['email']) : "",						
						];
	
						// Validate security csrf token
						if(!$validate->validate_csrf_token()) {
							$this->message = "<p class='alert alert-danger text-center'>Invalid CSRF token</p>";												
						}
						else {
							if($validate->validate_form($this->fields)) {
								$query = new Query();
			
								$rows = $query->selectAllBy("user", "email", $this->fields['email']);
			
								if($rows) {
									$this->message = "<p class='alert alert-danger text-center'>" . ucfirst($this->language['email_registered']) . "</p>";																	
								}
								else {	
									$user = new User($this->fields);						
									$userRepository = new UserRepository(); 
									
									$userRepository->save($user);			
									$this->message = "<p class='alert alert-success text-center'>El usuario se ha registrado correctamente</p>";
		
									$this->render("/view/database_error.php", [
										'message'	=>	$this->message
									]);
								}
							}
							else {
								$this->message = $validate->get_msg();
							}
						}
					}																									
				}								
				
				$this->render("/view/register_view.php", [
					'message'	=>	$this->message,
					'fields'	=>	$this->fields,
					'csrf' 		=> 	$validate
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