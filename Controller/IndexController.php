<?php
    namespace Controller;

use model\classes\QueryMenuDay;

    class IndexController
    {        
        public function index(object $dbcon)
        {
            $menuDayQuery = new QueryMenuDay();

            $primeros = $menuDayQuery->selectAllDishesByCategory("primero", $dbcon);
            $segundos = $menuDayQuery->selectAllDishesByCategory("segundo", $dbcon);
            $postres = $menuDayQuery->selectAllDishesByCategory("postre", $dbcon);
           
            include(SITE_ROOT . "/../view/main_view.php");
        }
    }    
?>