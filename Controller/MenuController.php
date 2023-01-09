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
                        $showResult .= '<div class="col-6 col-lg-3"><ul>';
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

            $aperitifs = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "aperitivos", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($aperitifs); $i++) {                
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

            include(SITE_ROOT . "/../view/menu/aperitifs_view.php");
        }

        public function starts()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show aperitifs */

            $starts = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "entrantes", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($starts); $i++) {                
                $start = ucfirst($starts[$i]['name']);
                $showResult .= "<li><a href='/menu/starts/{$starts[$i]['dishe_id']}.php'>{$start}</a></li>";
                if($i == $y || $i == count($starts)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($starts)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }               
            }

            include(SITE_ROOT . "/../view/menu/starts_view.php");
        }

        public function salads()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show salads */

            $salads = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "ensaladas", $this->dbcon);           
            $showResult = "";                       

            for($i = 0, $y = 3; $i < count($salads); $i++) {                
                $salad = ucfirst($salads[$i]['name']);
                $showResult .= "<li><a href='/menu/salads/{$salads[$i]['dishe_id']}.php'>{$salad}</a></li>";
                if($i == $y || $i == count($salads)) {
                    $showResult .= "</ul></div>";
                    if($y < count($salads)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }                
            }

            include(SITE_ROOT . "/../view/menu/salads_view.php");
        }

        public function meats()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show salads */

            $meats = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "carnes", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($meats); $i++) {                
                $meat = ucfirst($meats[$i]['name']);
                $showResult .= "<li><a href='/menu/meats/{$meats[$i]['dishe_id']}.php'>{$meat}</a></li>";
                if($i == $y || $i == count($meats)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($meats)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }               
            }

            include(SITE_ROOT . "/../view/menu/meats_view.php");
        }

        public function fishes()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show salads */

            $fishes = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "pescados", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($fishes); $i++) {                
                $fish = ucfirst($fishes[$i]['name']);
                $showResult .= "<li><a href='/menu/fishes/{$fishes[$i]['dishe_id']}.php'>{$fish}</a></li>";
                if($i == $y || $i == count($fishes)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($fishes)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }               
            }

            include(SITE_ROOT . "/../view/menu/fishes_view.php");
        }

        public function rices()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show salads */

            $rices = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "arroces", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($rices); $i++) {                
                $rice = ucfirst($rices[$i]['name']);
                $showResult .= "<li><a href='/menu/rices/{$rices[$i]['dishe_id']}.php'>{$rice}</a></li>";
                if($i == $y || $i == count($rices)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($rices)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }               
            }

            include(SITE_ROOT . "/../view/menu/rices_view.php");
        }

        public function desserts()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show salads */

            $desserts = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "postres", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($desserts); $i++) {                
                $dessert = ucfirst($desserts[$i]['name']);
                $showResult .= "<li><a href='/menu/desserts/{$desserts[$i]['dishe_id']}.php'>{$dessert}</a></li>";
                if($i == $y || $i == count($desserts)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($desserts)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }               
            }

            include(SITE_ROOT . "/../view/menu/desserts_view.php");
        }

        public function coffes()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show salads */

            $coffes = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "cafés", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($coffes); $i++) {                
                $coffe = ucfirst($coffes[$i]['name']);
                $showResult .= "<li><a href='/menu/coffes/{$coffes[$i]['dishe_id']}.php'>{$coffe}</a></li>";
                if($i == $y || $i == count($coffes)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($coffes)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }               
            }

            include(SITE_ROOT . "/../view/menu/coffes_view.php");
        }

        public function redsWines()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show salads */

            $redsWines = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "tintos", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($redsWines); $i++) {                
                $redWine = ucfirst($redsWines[$i]['name']);
                $showResult .= "<li><a href='/menu/wines/reds/{$redsWines[$i]['dishe_id']}.php'>{$redWine}</a></li>";
                if($i == $y || $i == count($redsWines)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($redsWines)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }               
            }

            include(SITE_ROOT . "/../view/menu/reds_view.php");
        }

        public function whitesWines()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show salads */

            $whitesWines = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "blancos", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($whitesWines); $i++) {                
                $whiteWine = ucfirst($whitesWines[$i]['name']);
                $showResult .= "<li><a href='/menu/wines/whites/{$whitesWines[$i]['dishe_id']}.php'>{$whiteWine}</a></li>";
                if($i == $y || $i == count($whitesWines)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($whitesWines)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }               
            }

            include(SITE_ROOT . "/../view/menu/whites_view.php");
        }

        public function pinkWines()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show salads */

            $pinkWines = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "rosados", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($pinkWines); $i++) {                
                $pinkWine = ucfirst($pinkWines[$i]['name']);
                $showResult .= "<li><a href='/menu/wines/pinks/{$pinkWines[$i]['dishe_id']}.php'>{$pinkWine}</a></li>";
                if($i == $y || $i == count($pinkWines)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($pinkWines)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }               
            }

            include(SITE_ROOT . "/../view/menu/pinks_view.php");
        }

        public function sparklingWines()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show salads */

            $sparklingWines = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "cavas", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($sparklingWines); $i++) {                
                $sparklingWine = ucfirst($sparklingWines[$i]['name']);
                $showResult .= "<li><a href='/menu/sparklings/{$sparklingWines[$i]['dishe_id']}.php'>{$sparklingWine}</a></li>";
                if($i == $y || $i == count($sparklingWines)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($sparklingWines)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }               
            }

            include(SITE_ROOT . "/../view/menu/sparklings_view.php");
        }

        public function champagne()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show salads */

            $champagnes = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "champagne", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($champagnes); $i++) {                
                $champagne = ucfirst($champagnes[$i]['name']);
                $showResult .= "<li><a href='/menu/champagnes/{$champagnes[$i]['dishe_id']}.php'>{$champagne}</a></li>";
                if($i == $y || $i == count($champagnes)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($champagnes)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }               
            }

            include(SITE_ROOT . "/../view/menu/champagne_view.php");
        }

        public function drinks()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show salads */

            $drinks = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "bebidas", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($drinks); $i++) {                
                $drink = ucfirst($drinks[$i]['name']);
                $showResult .= "<li><a href='/menu/drinks/{$drinks[$i]['dishe_id']}.php'>{$drink}</a></li>";
                if($i == $y || $i == count($drinks)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($drinks)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }                
            }

            include(SITE_ROOT . "/../view/menu/drinks_view.php");
        }

        public function liquors()
        {
            $menuDay = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDay->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDay->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDay->selectDishesOfDay("postre", $this->dbcon);

            /** Show salads */

            $liquors = $menuDay->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "licores", $this->dbcon);           
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($liquors); $i++) {                
                $liquor = ucfirst($liquors[$i]['name']);
                $showResult .= "<li><a href='/menu/liquors/{$liquors[$i]['dishe_id']}.php'>{$liquor}</a></li>";
                if($i == $y || $i == count($liquors)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($liquors)) {
                        $showResult .= '<div class="col-3"><ul>';
                    }

                    $y +=4; 
                }               
            }

            include(SITE_ROOT . "/../view/menu/liquors_view.php");
        }
    }
    
?>