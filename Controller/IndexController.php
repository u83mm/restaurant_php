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
            $menuDayQuery = new QueryMenu($this->dbcon);            

            $primeros = $menuDayQuery->selectDishesOfDay("primero");
            $segundos = $menuDayQuery->selectDishesOfDay("segundo");
            $postres = $menuDayQuery->selectDishesOfDay("postre");
           
            include(SITE_ROOT . "/../view/main_view.php");
        }
    }    
?>  