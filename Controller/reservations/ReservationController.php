<?php
    declare(strict_types=1);
    
    namespace Controller\reservations;

    use model\classes\Language;
    use model\classes\Query;
    use model\classes\QueryMenu;
    use model\classes\Validate;

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
        public function index(): void
        {                                 
            try {
                $menuDayQuery = new QueryMenu();            

                /** Show diferent Menu's day dishes */
                $primeros = $menuDayQuery->selectDishesOfDay("primero", $this->dbcon);
                $segundos = $menuDayQuery->selectDishesOfDay("segundo", $this->dbcon);
                $postres = $menuDayQuery->selectDishesOfDay("postre", $this->dbcon);


                /** Calculate menu's day price */
                $menuDayPrice = $menuDayQuery->getMenuDayPrice($this->dbcon);

                /** Hours to show in select element */
                $hours = [12.00, 12.30, 13.00, 13.30, 14.00, 14.30, 15.00];

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
        
        /** Save a reservation date */
        public function saveReservation() : void 
        {
            $validate = new Validate;

            // Get values from reservations form
            $fields = [
                "date"          =>  $validate->test_input($_POST['date']),
                "time"          =>  $validate->test_input($_POST['time']),
                "name"          =>  $validate->test_input($_POST['name']),
                "people_qty"    =>  $validate->test_input($_POST['qty']),                   
            ];            
            
            try {
                // Validate form
                $ok = $validate->validate_form($fields);

                if($ok) {
                    if(!empty($_POST['comment'])) {
                        $fields['comment'] = $validate->test_input($_POST['comment']);
                    }                   
                    
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

                include(SITE_ROOT . "/../view/database_error.php");
            }
        }

        /** Show current reservations */
        public function showReservations() : void 
        {
            try {
                $menuDayQuery = new QueryMenu();            

                /** Show diferent Menu's day dishes */
                $primeros = $menuDayQuery->selectDishesOfDay("primero", $this->dbcon);
                $segundos = $menuDayQuery->selectDishesOfDay("segundo", $this->dbcon);
                $postres = $menuDayQuery->selectDishesOfDay("postre", $this->dbcon);


                /** Calculate menu's day price */
                $menuDayPrice = $menuDayQuery->getMenuDayPrice($this->dbcon);

                /** Get reservations */
                $query = new Query();

                $rows = $query->selectFieldsFromTableOrderByField(
                    'reservations', 
                    [
                        'name', 
                        'people_qty', 
                        'time', 
                        'comment'
                    ], 
                    'time', 
                    $this->dbcon
                );                
                
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