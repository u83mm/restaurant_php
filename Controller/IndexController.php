<?php
    namespace Controller;

use model\classes\QueryMenuDay;

    class IndexController
    {
        public function __construct(private object $dbcon)
        {
                        
        }

        public function index()
        {
            $menuDayQuery = new QueryMenuDay($this->dbcon);            

            $primeros = $menuDayQuery->selectAllDishesByCategory("primero");
            $segundos = $menuDayQuery->selectAllDishesByCategory("segundo");
            $postres = $menuDayQuery->selectAllDishesByCategory("postre");
           
            include(SITE_ROOT . "/../view/main_view.php");
        }
    }    
?>