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
            $menuDayQuery = new QueryMenuDay();

            $primeros = $menuDayQuery->selectAllDishesByCategory("primero", $this->dbcon);
            $segundos = $menuDayQuery->selectAllDishesByCategory("segundo", $this->dbcon);
            $postres = $menuDayQuery->selectAllDishesByCategory("postre", $this->dbcon);
           
            include(SITE_ROOT . "/../view/main_view.php");
        }
    }    
?>