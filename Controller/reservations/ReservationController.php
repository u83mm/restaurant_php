<?php
    declare(strict_types=1);
    
    namespace Controller\reservations;

    use model\classes\QueryMenu;

    class ReservationController
    {
        public function __construct(private object $dbcon, private string $message = "")
        {
                        
        }
     
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
    }    
?>  