<?php
    namespace Controller;

    use model\classes\QueryMenu;

    class IndexController
    {
        public function __construct(private object $dbcon)
        {
                        
        }

        public function index()
        {
            $menuDayQuery = new QueryMenu();            

            $primeros = $menuDayQuery->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDayQuery->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDayQuery->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDayQuery->getMenuDayPrice($this->dbcon);                       
           
            include(SITE_ROOT . "/../view/main_view.php");
        }
    }    
?>  