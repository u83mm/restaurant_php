<?php
    namespace Controller;

    use model\classes\CommonTasks;
    use model\classes\QueryMenu;    
    use model\fpdf\MyPdf;

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
            
            
            /** Calculate menu's day price */

            $menuDayPrice = $menuDay->getMenuDayPrice($this->dbcon);


            /** Show Menu's categories */

            $menuCategories = $menuDay->selectAll("dishes_menu", $this->dbcon);            
            $showResult = "";

            for($i = 0, $y = 3; $i < count($menuCategories); $i++) {
                $category = ucfirst($menuCategories[$i]['menu_category']);
                $showResult .= "<li><a href='{$menuCategories[$i]['menu_category']}.php'>{$category}</a></li>";
                if($i == $y || $i == count($menuCategories)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($menuCategories)) {
                        $showResult .= '<div class="col-6 col-md-4 col-lg-3"><ul>';
                    }

                    $y +=4; 
                }
            }

            include(SITE_ROOT . "/../view/menu/menu_view.php");
        }

        public function aperitifs(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Day's menu dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);
           

            /** Show aperitifs */

            $rows = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "aperitivos", $this->dbcon);                                
            $showResult = $menuDishes->showMenuListByCategory($rows, "aperitivos");
          
            include(SITE_ROOT . "/../view/menu/aperitifs_view.php");
        }

        public function starts(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show the diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);


            /** Show starts */

            $starts = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "entrantes", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($starts, "entrantes");                     

            include(SITE_ROOT . "/../view/menu/starts_view.php");
        }

        public function salads(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);
            

            /** Show salads */

            $salads = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "ensaladas", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($salads, "ensaladas");                       
            
            include(SITE_ROOT . "/../view/menu/salads_view.php");
        }

        public function meats(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon); 
            
            
            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);


            /** Show meats */

            $meats = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "carnes", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($meats, "carnes");                        

            include(SITE_ROOT . "/../view/menu/meats_view.php");
        }

        public function fishes(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);


            /** Show fishes */

            $fishes = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "pescados", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($fishes, "pescados");                        

            include(SITE_ROOT . "/../view/menu/fishes_view.php");
        }

        public function rices(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);
            

            /** Show rices */

            $rices = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "arroces", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($rices, "arroces");                       

            include(SITE_ROOT . "/../view/menu/rices_view.php");
        }

        public function desserts(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);
            

            /** Show deserts */

            $desserts = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "postres", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($desserts, "postres");                        

            include(SITE_ROOT . "/../view/menu/desserts_view.php");
        }

        public function coffes(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);
            

            /** Show coffes */

            $coffes = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "cafés", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($coffes, "cafés");            

            include(SITE_ROOT . "/../view/menu/coffes_view.php");
        }

        public function redsWines(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);
            

            /** Show salads */

            $redsWines = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "tintos", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($redsWines, "tintos");                        

            include(SITE_ROOT . "/../view/menu/reds_view.php");
        }

        public function whitesWines(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);

            
            /** Show salads */

            $whitesWines = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "blancos", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($whitesWines, "blancos");                        

            include(SITE_ROOT . "/../view/menu/whites_view.php");
        }

        public function pinkWines(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);
            

            /** Show salads */

            $pinkWines = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "rosados", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($pinkWines, "rosados");                       

            include(SITE_ROOT . "/../view/menu/pinks_view.php");
        }

        public function sparklingWines(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);
            

            /** Show wines */

            $sparklingWines = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "cavas", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($sparklingWines, "cavas");                        

            include(SITE_ROOT . "/../view/menu/sparklings_view.php");
        }

        public function champagne(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);

            
            /** Show champagnes */

            $champagnes = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "champagne", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($champagnes, "champagne");                        

            include(SITE_ROOT . "/../view/menu/champagne_view.php");
        }

        public function drinks(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);

            
            /** Show drinks */

            $drinks = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "bebidas", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($drinks, "bebidas");                        

            include(SITE_ROOT . "/../view/menu/drinks_view.php");
        }

        public function liquors(): void
        {
            $menuDishes = new QueryMenu();            

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);
            

            /** Show liquors */

            $liquors = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", "licores", $this->dbcon);           
            $showResult = $menuDishes->showMenuListByCategory($liquors, "licores");                        

            include(SITE_ROOT . "/../view/menu/liquors_view.php");
        }

        public function showDisheInfo(string $id): void
        {
            $menuDishes = new QueryMenu();
            $commonTask = new CommonTasks();           

            /** Show diferent Menu's day dishes */

            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon); 
            
            
            /** Calculate menu's day price */

            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);


            /** We obtain the dishe info to show */
           
            $dishe = $menuDishes->selectOneByIdInnerjoinOnfield("dishes", "dishes_menu","menu_id", "dishe_id", $id, $this->dbcon);
            $description = $commonTask->divideTextInParagrahs($dishe['description']);
            $dishe_picture = $commonTask->getWebPath($dishe['picture'] ?? $dishe['picture'] = "");                        

            include(SITE_ROOT . "/../view/menu/show_dishe_view.php");
        }

        /**
         * It creates a PDF file with the title "Nuestra Carta" and shows it in the browser.
         */
        public function menu(): void
        {   
            define('FPDF_FONTPATH', SITE_ROOT .'/../model/fpdf/font');
            define('EURO_SIMBOL', chr(128)); 

            $pdf = new MyPdf();
            
            /** We obtain Menu's categories */

            $menu = new QueryMenu();  
            $menuCategories = $menu->selectAll("dishes_menu", $this->dbcon);    
            

            /** Start to build the menu */

            $pdf->title = "Nuestra Carta";
            //$pdf->SetLineWidth(2); 
            $pdf->SetFillColor(0, 54.5, 54.5);           
            $pdf->AddPage();
            $pdf->AliasNbPages();
            $pdf->SetFont('Arial','B',12); 


            /** Show all the categories and their dishes*/

            foreach ($menuCategories as $key => $category) {                
                $pdf->Cell(150, 10, iconv('UTF-8', 'ISO-8859-1', ucfirst($category['menu_category'])), 0, 0, '');
                $pdf->Cell(0, 10, "Precio", 0, 0, "");                
                //$pdf->Line(10, $pdf->getY()+10, $pdf->getX() -3, $pdf->GetY() + 10);
                $pdf->Rect(10, $pdf->getY()+10, 170, 2, "F");                                               
                $pdf->Ln(10);


                /** Show dishes */

                $rows = $menu->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", $category['menu_category'], $this->dbcon);                                                              

                foreach ($rows as $key => $value) {
                    $pdf->SetFont('Arial','I',10);
                    if($value['available'] === "SI") {
                        $pdf->Cell(150, 10, iconv('UTF-8', 'ISO-8859-1', ucfirst($value['name'])), 0, 0, 'L');
                        $pdf->Cell(20, 10, $value['price'] . " " . EURO_SIMBOL, 0, 0, 'R');                                                                  
                    }
                    $pdf->Ln(5);
                    $pdf->SetFont('Arial','B',12);
                }
                $pdf->Ln(20);
            }            
            
            $pdf->Output('', 'Menu.pdf');            
        }
    }
    
?>