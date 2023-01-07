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
            $menuDay = new QueryMenu($this->dbcon);
            $menuCategory = new Query($this->dbcon); 


            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero");
            $segundos = $menuDay->selectDishesOfDay("segundo");
            $postres = $menuDay->selectDishesOfDay("postre");


            /** Show Menu's categories */

            $menuCategories = $menuCategory->selectAll("dishes_menu");            
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
    }
    
?>