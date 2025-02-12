<?php
    declare(strict_types=1);

    namespace Application\Controller\reservations;

    use Application\Core\Controller;
    use Application\model\classes\CommonTasks;
    use Application\model\classes\Language;
    use Application\model\classes\Query;
    use Application\model\classes\QueryMenu;
    use Application\model\classes\QueryReservations;
    use Application\model\classes\Validate;
   
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use Resend;

    class ReservationController extends Controller
    {
        /** Create array and object for diferent languages */
        private array $language = [];
        private Language $languageObject;
        private array $menuDaySections = [];

        public function __construct(
            private object $dbcon = DB_CON, 
            private string $message = "",
            private array $fields = [],
            private CommonTasks $commonTasks = new CommonTasks(),
            private Query $query = new Query(),
            private QueryMenu $menuDayQuery = new QueryMenu(),
            private QueryReservations $queryReservations = new QueryReservations()
        )
        {
            $this->languageObject = new Language(); 
            
            /** Configure page language */
            $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();
            
            /** Get dishes, dessert and price to show in the Day's menu aside section */
            $this->menuDaySections = $this->menuDayQuery->getMenuDayElements();
        }
     
        /** Show reservations form */
        public function index(): void
        {                                 
            try {                                                                      
                /** Hours to show in select element */
                $rows = $this->query->selectAll('dinner_hours');                
                $hours = [];

                foreach ($rows as $key => $value) {
                    $hours[] = $value['hour'];
                }                

                /** Show people qty options in select element */
                $people = [];

                for($i = 1; $i <= 20; $i++ ) {
                    array_push($people, $i);
                }

                /** Fields to render */
                $this->fields = [
                    'date'            => date('Y-m-d'),
                    'hours'           => $hours,
                    'people'          => $people,
                    'menuDaySections' => $this->menuDaySections,
                    'message'         => $this->message,
                ];                                               

                $this->render('/view/reservations/reservation_view.php', [
                    'fields' => $this->fields,
                ]);

            } catch (\Throwable $th) {
                $$this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $$this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }                

                $this->render('/view/database_error.php', [
                    'message' => $this->message
                ]);
            }
        } 
        
        /** Save a reservation */
        public function save() : void 
        {
            $validate = new Validate;            
                                  
            try {
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Get values from reservations form
                    $this->fields = [
                        "date"          =>  $validate->test_input($_POST['date']),
                        "time"          =>  $validate->test_input($_POST['time']),
                        "name"          =>  $validate->test_input($_POST['name']),
                        "email"         =>  $validate->test_input($_POST['email']), 
                        "people_qty"    =>  $validate->test_input($_POST['qty']),                                    
                    ];

                    if(!empty($_POST['comment'])) {
                        $this->fields['comment'] = $validate->test_input($_POST['comment']);
                    }                                       

                    // Validate form                                             
                    if($validate->validate_form($this->fields)) {
                        // Send emails with Resend API to test functionality
                        require_once SITE_ROOT . '/../vendor/autoload.php';                                       
                        /* $resend = Resend::client(RESEND_API_KEY);

                        $resend->emails->send([
                            'from'      =>  'Restaurant Your House <onboarding@resend.dev>',
                            'to'        =>  [
                                $this->fields['email'],                            
                            ],
                            'subject'   =>  ucfirst($this->language['reservation_received']),                        
                            'html'      =>  ucfirst($this->language['reservation_mail_intro_paragraph']) . "<br><br>" .
                                            ucfirst($this->language['reservation_mail_1th_paragraph']) .
                                            "
                                            <table style='margin-bottom: 2em'>
                                                <tr>
                                                    <td style='text-align: right;'>" . ucfirst($this->language['name']) . ":</td>
                                                    <td><strong>{$this->fields['name']}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td style='text-align: right;'>" . ucfirst($this->language['date']) . ":</td>
                                                    <td><strong>{$this->commonTasks->showDayMonthYear($this->fields['date'], $_SESSION['language'])}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td style='text-align: right;'>" . ucfirst($this->language['time']) . ":</td>
                                                    <td><strong>{$this->fields['time']}h</strong></td>
                                                </tr>
                                                <tr>
                                                    <td style='text-align: right;'>" . ucfirst($this->language['qty']) . ":</td>
                                                    <td><strong>{$this->fields['people_qty']} pers.</strong></td>
                                                </tr>
                                            </table>
                                            " . 
                                            $this->language['reservation_mail_2th_paragraph'] . " <br><br>" .
                                            ucfirst($this->language['thanks']) . "<br><br>" . 
                                            "Restaurant Your House<br>",
                                            
                            'text'      =>  ucfirst($this->language['reservation_mail_intro_paragraph']) . "\n\n" .
                                            ucfirst($this->language['reservation_mail_1th_paragraph']) . "\n\n" .                                    
                                            ucfirst($this->language['name']) . ":\t {$this->fields['name']}\n" . 
                                            ucfirst($this->language['date']) . ":\t {$this->fields['date']}\n" .
                                            ucfirst($this->language['time']) . ":\t {$this->fields['time']}h.\n" .
                                            ucfirst($this->language['qty'])  . ":\t {$this->fields['people_qty']} pers.\n\n" . 
                                            $this->language['reservation_mail_2th_paragraph'] . "\n\n" .
                                            ucfirst($this->language['thanks']) . "\n\n" . 
                                            "Restaurant Your House",   
                        ]); */

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
                        $this->query->insertInto('reservations', $this->fields);
                        $this->message = "<p class='alert alert-success text-center'>" . ucfirst($this->language['reservation_sent']) . "</p>";                                                
                        $this->index();
                    }
                    else {                        
                        /** Hours to show in select element */
                        $rows = $this->query->selectAll('dinner_hours');                
                        $hours = [];

                        foreach ($rows as $key => $value) {
                            $hours[] = $value['hour'];
                        }                

                        /** Show people qty options in select element */
                        $people = [];

                        for($i = 1; $i <= 20; $i++ ) {
                            array_push($people, $i);
                        }

                        $this->fields['hours']           = $hours;
                        $this->fields['message']         = $validate->get_msg();
                        $this->fields['people']          = $people;
                        $this->fields['menuDaySections'] = $this->menuDaySections;

                        $this->render('/view/reservations/reservation_view.php', [
                            'fields' => $this->fields,
                        ]);
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
                                
                $this->index();
            }
        }

        /** Show all reservations */
        public function showAllReservations() : void 
        {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            try {                                                                    
                /** Select all distint dates from current date */                            
                $rows = $this->queryReservations->selectDistinctDatesFromCurrent('reservations');                                                                      
                
                if(count($rows) > 0) {
                    foreach ($rows as $key => $value) {
                        $date[] = $this->commonTasks->showDayMonthYear($value['date'], $_SESSION['language']);
                    }
                }
                else {
                    $date[] = $this->commonTasks->showDayMonthYear(date('Y-m-d'), $_SESSION['language']);
                }
                     
                /** Get reservations */                
                $rows = $this->queryReservations->selectFieldsFromTableOrderByField(
                    'reservations', 
                    [
                        'name', 
                        'people_qty',
                        'date', 
                        'time', 
                        'comment'
                    ], 
                    'date'
                );                 
                                                            
                // Calculate total people
                $total = 0;
                
                foreach ($rows as $key => $value) {
                    $rows[$key]['date'] = $this->commonTasks->showDayMonthYear($value['date'], $_SESSION['language']);
                }                                 
                               
                $this->render('/view/reservations/reservations_index.php', [
                    'date' => $date,
                    'rows' => $rows,
                    'menuDaySections' => $this->menuDaySections,
                    'message' => $this->message,
                    'total' => $total
                ]);

            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                include(SITE_ROOT . "/../Application/view/database_error.php");
            }            
        }

        /** Show admin search view */
        public function showSearchPanel() : void 
        {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            $_SESSION['action'] = "search_panel";
            

            /** Hours to show in select element */
            $rows = $this->query->selectAll('dinner_hours');                
            $hours = [];

            foreach ($rows as $key => $value) {
                $hours[] = $value['hour'];
            }              
            
            /** Fields to render */
            $this->fields = [
                'hours'   => $hours,
                'message' => $this->message,
                'date'    => date('Y-m-d'),
            ];

            $this->render('/view/admin/reservations/search_view.php', [
                'fields' => $this->fields,
            ]);
        }

        /** Show search results */
        public function searchReservationsByDateAndTime() : void 
        { 
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            $_SESSION['action'] = "search";
            $_SESSION['date'] = $_POST['date'] ?? date('Y-m-d');

            try {                                                                     
                // Get date and time to make the query by date
                $dates = [
                    'date' => $_POST['date'] ?? date('Y-m-d'),
                ];                
                
                $time = isset($_POST['time']) ? $_POST['time'] : "";

                $rows = $this->queryReservations->selectAllByDateAndTime('reservations', 'date', $dates['date'], $time, 'time');                                                        
                
                // Format the date to show in the view results
                foreach ($dates as $key => $value) {
                    $date[$key] = $this->commonTasks->showDayMonthYear($value, $_SESSION['language']); 
                }                                 
                
                // Calculate total people
                $total = 0;

                foreach ($rows as $key => $value) {                   
                    $rows[$key]['date'] = $this->commonTasks->showDayMonthYear($value['date'], $_SESSION['language']);
                }                                                   

                $this->render('/view/reservations/reservations_index.php', [
                    'date' => $date,
                    'rows' => $rows,
                    'menuDaySections' => $this->menuDaySections,
                    'message' => $this->message,
                    'total' => $total
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

                $this->render('/view/database_error', [
                    'message' => $this->message
                ]);
            }
        }
    }    
?>