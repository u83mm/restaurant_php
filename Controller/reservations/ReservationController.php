<?php
    declare(strict_types=1);
    
    namespace Controller\reservations;

    use model\classes\CommonTasks;
    use model\classes\Language;
    use model\classes\Query;
    use model\classes\QueryMenu;
    use model\classes\QueryReservations;
    use model\classes\Validate;

    use PDO;

    class ReservationController
    {
        /** Create array and object for diferent languages */
        private array $language = [];
        private Language $languageObject;

        public function __construct(private object $dbcon, private string $message = "")
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

                /** Show diferent Menu's day dishes */
                $primeros = $menuDayQuery->selectDishesOfDay("primero", $this->dbcon);
                $segundos = $menuDayQuery->selectDishesOfDay("segundo", $this->dbcon);
                $postres = $menuDayQuery->selectDishesOfDay("postre", $this->dbcon);


                /** Calculate menu's day price */
                $menuDayPrice = $menuDayQuery->getMenuDayPrice($this->dbcon);

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
                    // Save row in DB
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

                //include(SITE_ROOT . "/../view/database_error.php");
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

                /** Show diferent Menu's day dishes */
                $primeros = $menuDayQuery->selectDishesOfDay("primero", $this->dbcon);
                $segundos = $menuDayQuery->selectDishesOfDay("segundo", $this->dbcon);
                $postres = $menuDayQuery->selectDishesOfDay("postre", $this->dbcon);


                /** Calculate menu's day price */
                $menuDayPrice = $menuDayQuery->getMenuDayPrice($this->dbcon);


                /** Select all distint dates from current date */                            
                $rows = $queryReservations->selectDistinctDatesFromCurrent('reservations', $this->dbcon);                                                       
                
                if(count($rows) > 0) {
                    foreach ($rows as $key => $value) {
                        $date[] = $commonTasks->showDayMonthYear($value['date'], $_SESSION['language']);
                    }
                }
                else {
                    $date[] = date('d/m/Y');
                }
                     
                /** Get reservations */
                $query = new Query();

                $rows = $query->selectFieldsFromTableOrderByField(
                    'reservations', 
                    [
                        'name', 
                        'people_qty',
                        'date', 
                        'time', 
                        'comment'
                    ], 
                    'time', 
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

                /** Show diferent Menu's day dishes */
                $primeros = $menuDayQuery->selectDishesOfDay("primero", $this->dbcon);
                $segundos = $menuDayQuery->selectDishesOfDay("segundo", $this->dbcon);
                $postres = $menuDayQuery->selectDishesOfDay("postre", $this->dbcon);


                /** Calculate menu's day price */
                $menuDayPrice = $menuDayQuery->getMenuDayPrice($this->dbcon);

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