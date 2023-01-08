<?php
    namespace Controller;

use model\classes\Query;
use model\classes\QueryMenu;

    class MenuController
    {
        public function __construct(private object $dbcon)      
        {
            
        }

        public function index(): void
        {
            $menuDay = new QueryMenu();           

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);


            /** Show Menu's categories */

            $menuCategories = $menuDay->selectAll("dishes_menu", $this->dbcon);            
            $showResult = "";

            for($i = 0, $y = 3; $i < count($menuCategories); $i++) {
                $category = ucfirst($menuCategories[$i]['menu_category']);
                $showResult .= "<li><a href='{$menuCategories[$i]['menu_category']}.php'>{$category}</a></li>";
                if($i == $y || $i == count($menuCategories)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($menuCategories)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }
            }

            include(SITE_ROOT . "/../view/menu/menu_view.php");
        }

        public function aperitifs(): void
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show aperitifs */

            $aperitifs = $menuDay->selectAllInnerjoin("dishes", "dishes_menu", "menu_id", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($aperitifs); $i++) {                
                if($aperitifs[$i]['menu_category'] === "aperitivos") {
                    $aperitif = ucfirst($aperitifs[$i]['name']);
                    $showResult .= "<li><a href='/menu/aperitifs/{$aperitifs[$i]['dishe_id']}.php'>{$aperitif}</a></li>";
                    if($i == $y || $i == count($aperitifs)-1) {
                        $showResult .= "</ul></div>";
                        if($y < count($aperitifs)) {
                            $showResult .= '<div class="col-3"><ul>';
                        }

                        $y +=4; 
                    }
                }                
            }

            include(SITE_ROOT . "/../view/menu/aperitifs_view.php");
        }
    }
    
?>