<?php
    declare(strict_types=1);
    
    //namespace Controller\reservations;

    use model\classes\CommonTasks;
    use model\classes\Language;
    use model\classes\Query;
    use model\classes\QueryMenu;
    use model\classes\QueryReservations;
    use model\classes\Validate;

    //use PDO;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    //use Resend;

    class ReservationController
    {
        /** Create array and object for diferent languages */
        private array $language = [];
        private Language $languageObject;

        public function __construct(private object $dbcon = DB_CON, private string $message = "")
        {
            $this->languageObject = new Language(); 
            
            /** Configure page language */
            $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english(); 
        }
     
        /** Show reservations form */
        public function index(array $fields = []): void
        {                                 
            try {                
                $menuDayQuery = new QueryMenu();
                $query = new Query();          

                /** Get dishes, dessert and price to show in the Day's menu aside section */
                $menuDaySections = $menuDayQuery->getMenuDayElements();

                /** Hours to show in select element */
                $rows = $query->selectAll('dinner_hours', $this->dbcon);                
                $hours = [];

                foreach ($rows as $key => $value) {
                    $hours[] = $value['hour'];
                }                

                /** People qty to show in select element */
                $people = [];

                for($i = 1; $i <= 20; $i++ ) {
                    array_push($people, $i);
                }                                

                include(SITE_ROOT . "/../view/reservations/reservation_view.php");

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
        
        /** Save a reservation */
        public function saveReservation() : void 
        {
            $validate = new Validate;
                                  
            try {
                // Get values from reservations form
                $fields = [
                    "date"          =>  $validate->test_input($_POST['date']),
                    "time"          =>  $validate->test_input($_POST['time']),
                    "name"          =>  $validate->test_input($_POST['name']),
                    "email"         =>  $validate->validate_email($_POST['email']), 
                    "people_qty"    =>  $validate->test_input($_POST['qty']),                                    
                ];

                if(!empty($_POST['comment'])) {
                    $fields['comment'] = $validate->test_input($_POST['comment']);
                }
                
                // Validate email
                if(!$fields['email']) {
                    $this->message = "<p class='alert alert-danger text-center'>Enter a valid email please</p>";
                    $fields['email'] = $_POST['email'];
                                        
                    $this->index($fields);
                    exit();
                }
                else {
                    $fields['email'] = $validate->test_input($_POST['email']);
                } 

                // Validate form
                $ok = $validate->validate_form($fields);  
                             
                if($ok) {
                    // Send emails with Resend API to test functionality
                    require_once SITE_ROOT . '/../vendor/autoload.php';                                       
                    $resend = Resend::client(RESEND_API_KEY);

                    $resend->emails->send([
                        'from'      =>  'Restaurant Your House <onboarding@resend.dev>',
                        'to'        =>  [
                            $fields['email'],                            
                        ],
                        'subject'   =>  ucfirst($this->language['reservation_received']),                        
                        'html'      =>  ucfirst($this->language['reservation_mail_intro_paragraph']) . "<br><br>" .
                                        ucfirst($this->language['reservation_mail_1th_paragraph']) .
                                        "
                                        <table style='margin-bottom: 2em'>
                                            <tr>
                                                <td style='text-align: right;'>" . ucfirst($this->language['name']) . ":</td>
                                                <td><strong>{$fields['name']}</strong></td>
                                            </tr>
                                            <tr>
                                                <td style='text-align: right;'>" . ucfirst($this->language['date']) . ":</td>
                                                <td><strong>{$fields['date']}</strong></td>
                                            </tr>
                                            <tr>
                                                <td style='text-align: right;'>" . ucfirst($this->language['time']) . ":</td>
                                                <td><strong>{$fields['time']}h</strong></td>
                                            </tr>
                                            <tr>
                                                <td style='text-align: right;'>" . ucfirst($this->language['qty']) . ":</td>
                                                <td><strong>{$fields['people_qty']} pers.</strong></td>
                                            </tr>
                                        </table>
                                        " . 
                                        $this->language['reservation_mail_2th_paragraph'] . " <br><br>" .
                                        ucfirst($this->language['thanks']) . "<br><br>" . 
                                        "Restaurant Your House<br>",
                                        
                        'text'      =>  ucfirst($this->language['reservation_mail_intro_paragraph']) . "\n\n" .
                                        ucfirst($this->language['reservation_mail_1th_paragraph']) . "\n\n" .                                    
                                        ucfirst($this->language['name']) . ":\t {$fields['name']}\n" . 
                                        ucfirst($this->language['date']) . ":\t {$fields['date']}\n" .
                                        ucfirst($this->language['time']) . ":\t {$fields['time']}h.\n" .
                                        ucfirst($this->language['qty'])  . ":\t {$fields['people_qty']} pers.\n\n" . 
                                        $this->language['reservation_mail_2th_paragraph'] . "\n\n" .
                                        ucfirst($this->language['thanks']) . "\n\n" . 
                                        "Restaurant Your House",   
                    ]);

                    // Send confirmation email for a reservation using PHPMailer 
                    /* require_once SITE_ROOT . '/../vendor/autoload.php';
                    $mail = new PHPMailer(true);

                    // Config for development                
                    $mail->isSMTP();
                    $mail->Host = "mailer";
                    $mail->Port = 1025;
                    $mail->CharSet = "UTF8"; */

                    // Config for production
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;           //Enable verbose debug output
                    //$mail->isSMTP();                                   //Send using SMTP
                    //$mail->Host       = 'localhost';                    //Set the SMTP server to send through
                    //$mail->SMTPAuth   = true;                          //Enable SMTP authentication
                    //$mail->Username   = 'testsender2';                    //SMTP username
                    //$mail->Password   = '';                  //SMTP password
                    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   //Enable implicit TLS encryption                    
                    //$mail->Port       = 587;  

                    // Recipients
                    /* $mail->setFrom('restaurant@yourhouse.com', 'Restaurant Your House');
                    $mail->addAddress($fields['email']); */
                    /* $mail->addReplyTo('info@yourhouse.com', 'Information');
                    $mail->addCC('reception@yourhouse.com');
                    $mail->addBCC('bcc@example.com');  */              

                    // Attachments                                                                                              
                    /* $mail->addEmbeddedImage(SITE_ROOT . '/images/main_logo.png', 'main_logo');
                    $mail->addEmbeddedImage(SITE_ROOT . '/images/restaurant_logo.png', 'restaurant_logo'); */

                    // Content
                    /* $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = ucfirst($this->language['reservation_received']);
                    $mail->Body    = "<div style='padding-left: 1em;'><img width='200' src='cid:main_logo' alt='main logo'><br><br>" .
                                    ucfirst($this->language['reservation_mail_intro_paragraph']) . "<br><br>" .
                                    ucfirst($this->language['reservation_mail_1th_paragraph']) .
                                    "
                                    <table style='margin-bottom: 2em'>
                                        <tr>
                                            <td style='text-align: right;'>" . ucfirst($this->language['name']) . ":</td>
                                            <td><strong>{$fields['name']}</strong></td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: right;'>" . ucfirst($this->language['date']) . ":</td>
                                            <td><strong>{$fields['date']}</strong></td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: right;'>" . ucfirst($this->language['time']) . ":</td>
                                            <td><strong>{$fields['time']}h</strong></td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: right;'>" . ucfirst($this->language['qty']) . ":</td>
                                            <td><strong>{$fields['people_qty']} pers.</strong></td>
                                        </tr>
                                    </table>
                                    " . 
                                    $this->language['reservation_mail_2th_paragraph'] . " <br><br>" .
                                    ucfirst($this->language['thanks']) . "<br><br>" . 
                                    "Restaurant Your House<br>" . 
                                    "<img style='padding: 1em; width: 7em;' src='cid:restaurant_logo' alt='restaurant logo'><br><br></div>"; */
                    /* $mail->AltBody = ucfirst($this->language['reservation_mail_intro_paragraph']) . "\n\n" .
                                    ucfirst($this->language['reservation_mail_1th_paragraph']) . "\n\n" .                                    
                                    ucfirst($this->language['name']) . ":\t {$fields['name']}\n" . 
                                    ucfirst($this->language['date']) . ":\t {$fields['date']}\n" .
                                    ucfirst($this->language['time']) . ":\t {$fields['time']}h.\n" .
                                    ucfirst($this->language['qty'])  . ":\t {$fields['people_qty']} pers.\n\n" . 
                                    $this->language['reservation_mail_2th_paragraph'] . "\n\n" .
                                    ucfirst($this->language['thanks']) . "\n\n" . 
                                    "Restaurant Your House";                     
                
                    if(!$mail->send()) throw new \Exception("{$mail->ErrorInfo}", 1);*/
                    
                    // Save reservation in DB
                    $query = new Query();
                    $query->insertInto('reservations', $fields, $this->dbcon);
                    $this->message = "<p class='alert alert-success text-center'>" . ucfirst($this->language['reservation_sent']) . "</p>";
                    
                    // Redirect to reservations view
                    $this->index();
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
                
                $this->message = $error_msg;
                $this->index();
            }
        }

        /** Show all reservations */
        public function showAllReservations() : void 
        {
            try {
                $menuDayQuery = new QueryMenu(); 
                $commonTasks = new CommonTasks; 
                $queryReservations = new QueryReservations();          

                /** Get dishes, dessert and price to show in the Day's menu aside section */
                $menuDaySections = $menuDayQuery->getMenuDayElements(); 


                /** Select all distint dates from current date */                            
                $rows = $queryReservations->selectDistinctDatesFromCurrent('reservations', $this->dbcon);                                                                      
                
                if(count($rows) > 0) {
                    foreach ($rows as $key => $value) {
                        $date[] = $commonTasks->showDayMonthYear($value['date'], $_SESSION['language']);
                    }
                }
                else {
                    $date[] = $commonTasks->showDayMonthYear(date('Y-m-d'), $_SESSION['language']);
                }
                     
                /** Get reservations */                
                $rows = $queryReservations->selectFieldsFromTableOrderByField(
                    'reservations', 
                    [
                        'name', 
                        'people_qty',
                        'date', 
                        'time', 
                        'comment'
                    ], 
                    'date', 
                    $this->dbcon
                );                 
                                                            
                // Calculate total people
                $total = 0;
                
                foreach ($rows as $key => $value) {
                    $rows[$key]['date'] = $commonTasks->showDayMonthYear($value['date'], $_SESSION['language']);
                }                                 
                
                include(SITE_ROOT . "/../view/reservations/reservations_index.php");

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

        /** Show admin search view */
        public function showSearchPanel() : void 
        {
            $_SESSION['action'] = "search_panel";

            $query = new Query();

            /** Hours to show in select element */
            $rows = $query->selectAll('dinner_hours', $this->dbcon);                
            $hours = [];

            foreach ($rows as $key => $value) {
                $hours[] = $value['hour'];
            }  

            include(SITE_ROOT . "/../view/admin/reservations/search_view.php");    
        }

        /** Show search results */
        public function searchReservationsByDateAndTime() : void 
        {   
            $_SESSION['action'] = "search";
            $_SESSION['date'] = $_POST['date'] ?? date('Y-m-d');

            try {
                // Create objects
                $queryReservation = new QueryReservations();
                $menuDayQuery = new QueryMenu();
                $commonTasks = new CommonTasks;            

                /** Get dishes, dessert and price to show in the Day's menu aside section */
                $menuDaySections = $menuDayQuery->getMenuDayElements(); 

                // Get date and time to make the query by date
                $dates = [
                    'date' => $_POST['date'] ?? date('Y-m-d'),
                ];                
                
                $time = isset($_POST['time']) ? $_POST['time'] : "";

                $rows = $queryReservation->selectAllByDateAndTime('reservations', 'date', $dates['date'], $this->dbcon, $time, 'time');                                                        
                
                // Format the date to show in the view results
                foreach ($dates as $key => $value) {
                    $date[$key] = $commonTasks->showDayMonthYear($value, $_SESSION['language']); 
                }                                 
                
                // Calculate total people
                $total = 0;

                foreach ($rows as $key => $value) {                   
                    $rows[$key]['date'] = $commonTasks->showDayMonthYear($value['date'], $_SESSION['language']);
                }                                   

                include(SITE_ROOT . "/../view/reservations/reservations_index.php");

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