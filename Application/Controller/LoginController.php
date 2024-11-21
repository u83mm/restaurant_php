<?php
    declare(strict_types=1);

	namespace Application\Controller;

	use Application\Core\Controller;
	use model\classes\Language;
	use model\classes\Query;
	use model\classes\Validate;
	use PDO;

    /**
     * A class that contains the methods to login and logout. 
     */
    class LoginController extends Controller
    {       
		private Language $languageObject;
		

		public function __construct(
			private object $dbcon = DB_CON,
			private array $language = [],
			private string $message = "",
			private array $fields = [],
			private array $limited_access_data = [],
			private int $remaining_time = 0
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
			try {
				$this->testAccess(['ROLE_USER', 'ROLE_ADMIN']);	
				/* $this->fields = [
					'email'		=>	null,
					'password'	=>	null
				]; */			
						
				$validate = new Validate;
				$query_object = new Query();			            			

				if(!isset($_SESSION['id_user'])) {	
					// Test for restrictions
					$this->limited_access_data = $query_object->selectOneBy("limit_access", "ip", $_SERVER['REMOTE_ADDR']) ? 
						$query_object->selectOneBy("limit_access", "ip", $_SERVER['REMOTE_ADDR']) : [];						

					// If the IP is restricted, return the remaining time
					if(count($this->limited_access_data) > 0) {						
						if($this->limited_access_data['failed_tries'] >= 3) $this->remaining_time = $this->limited_access_data['restriction_time'] - time();
					}	
					
					if($_SERVER['REQUEST_METHOD'] === 'POST') {												
						// Get values from the form
						if(isset($_POST['email'], $_POST['password'])) {
							$this->fields = [
								'email'		=>	$validate->test_input($_POST['email']),
								'password'	=>	$validate->test_input($_POST['password']),
							];

							// Validate security csrf token
							if(!$validate->validate_csrf_token()) {
								$this->message = "<p class='alert alert-danger text-center'>Invalid CSRF token</p>";																					
							}
							else{
								// Doing login
								if($this->remaining_time <= 0) {							
									// Validate form
									if($validate->validate_form($this->fields)) {											
										try {										
											if(
												$result = $query_object->selectOneByFieldNameInnerjoinOnfield(
													'user', 
													'roles', 
													'id_role', 
													'email', 
													$this->fields['email']
												)
											) {																									
												// Test password
												if(password_verify($this->fields['password'], $result['password'])) {												
													$_SESSION['id_user'] = $result['id'];						
													$_SESSION['user_name'] = $result['user_name'];
													$_SESSION['role'] = $result['role'];																								

													// Delete the restriction time
													if(isset($this->limited_access_data['id'])) $query_object->deleteRegistry("limit_access", 'id', $this->limited_access_data['id']);										
																					
													header("Location: /");							
												}
												else {
													$this->message = "<p class='alert alert-danger text-center'>" . ucfirst($this->language['alert_login']) . "</p>";															
												}			
											}
											else {		
												$this->message = "<p class='alert alert-danger text-center'>" . ucfirst($this->language['alert_login']) . "</p>";																		
											}

											// Search if there is a restriction time
											if(isset($this->limited_access_data['id'])) {																																										
												// Update the restriction time										
												$this->limited_access_data['failed_tries'] += 1;
												$this->limited_access_data['restriction_time'] = time() + (5 * 60 );											
												$query_object->updateRow("limit_access", $this->limited_access_data, $this->limited_access_data['id']);
											}
											else {
												$this->limited_access_data['failed_tries'] = 1;

												// Insert into table limit_access
												$data = [
													'ip' => $_SERVER['REMOTE_ADDR'],
													'restriction_time' => time() + (5 * 60),
													'failed_tries' => $this->limited_access_data['failed_tries'],
													'created_at' => date('Y-m-d H:i:s')
												];

												if($validate->validate_form($data)) {											
													$query_object->insertInto("limit_access", $data);
												}
											}
											
										} catch (\Throwable $th) {					
											$this->message = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
											
											$this->render("/view/database_error.php", [
												'message'	=>	$this->message
											]);				
										}
									}
									else {
										$this->message = $validate->get_msg();
									}
								}
								else {
									$this->limited_access_data['failed_tries'] = 0;

									// Display message with remaining time (formatted)
									$minutes = floor($this->remaining_time / 60);
									$seconds = $this->remaining_time % 60;
									
									$this->message = "<p class='alert alert-danger text-center'>Please wait for " . $minutes . " minutes and " . $seconds . " seconds before trying again.</p>";							
								}
							}
						}																														
					}
					
					$this->render("/view/login_view.php", [
						'message'	=>	$this->message,
						'fields'	=>	$this->fields,
						'csrf' 		=> 	$validate
					]);
				}
				else {		
					header("Location: /");
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
                    'message' => $this->message
                ]);	
			}					
        }

        /* Unsetting the session variables and destroying the session. */
       	public function logout(): void
		{			
			unset($_SESSION['id_user']);
			unset($_SESSION['user_name']);
			unset($_SESSION['role']);

			session_unset();
			session_destroy();

			setcookie('PHPSESSID', '', time() - 3600);

			header("Location: /");
			exit();
		}
    }    
?>