<?php
    namespace Controller;

    use model\classes\CommonTasks;
    use model\classes\Language;
    use model\classes\QueryMenu;    
    use model\fpdf\MyPdf;

    class MenuController
    {
        private Language $languageObject;

        public function __construct(private object $dbcon, private array $language = [])      
        {
            $this->languageObject = new Language();
        }

        /**
         * The function displays different menu categories and their dishes, and calculates the menu's
         * day price.
         */
        public function index(): void
        {                    
            /** Configure page language */           
			$this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();
            
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
                $category = ucfirst($this->language["{$menuCategories[$i]['menu_category']}"]);                
                $emoji = $menuCategories[$i]['menu_emoji'];
                
                $showResult .= "<li class='showMenuCategories'>
                                    <form class='d-inline' action='{$_SERVER['PHP_SELF']}' method='POST'>                                       
                                        <button class='btn btn-outline-secondary text-start' type='submit' name='action' value='$category'><span class='px-2 float-start'>$emoji</span>$category</button>
                                    </form>
                                </li>";
            
                if($i == $y || $i == count($menuCategories)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($menuCategories)) {
                        $showResult .= '<div class="col-12 col-sm-6 col-md-4 col-lg-3"><ul class="ps-0">';
                    }

                    $y += 4; 
                }
            }

            include(SITE_ROOT . "/../view/menu/menu_view.php");
        }

        /**
         * This PHP function shows dishes by their category and calculates the menu day price.
         * 
         * @param string category The category of dishes to be shown.
         */
        public function showDishesByTheirCategory(string $category): void
        {
            // Change category's language to spanish to do the query to the DB
            $this->language = $this->languageObject->spanish();
            $category = $this->language[$category];                       

            $menuDishes = new QueryMenu();                  

            /** Show diferent Day's menu dishes */
            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon);


            /** Calculate menu's day price */
            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);
           

            /** Show dishes */
            $rows = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", $category, $this->dbcon);                   
            $showResult = $menuDishes->showMenuListByCategory($rows, $category);                           
          
            include(SITE_ROOT . "/../view/menu/category_view.php");
        }        

       /**
        * This PHP function shows information about a specific dish from a menu, including its
        * description, picture, and price.
        * 
        * @param string id The ID of the dish that needs to be displayed.
        */
        public function showDisheInfo(): void
        {            
            $_SESSION['dishe_id'] = strtolower($_POST['id'] ?? $_GET['id'] ?? $_SESSION['dishe_id']);
            
            $menuDishes = new QueryMenu();
            $commonTask = new CommonTasks(); 
                      

            /** Show diferent Menu's day dishes */
            $primeros = $menuDishes->selectDishesOfDay("primero", $this->dbcon);
            $segundos = $menuDishes->selectDishesOfDay("segundo", $this->dbcon);
            $postres = $menuDishes->selectDishesOfDay("postre", $this->dbcon); 
            
            
            /** Calculate menu's day price */
            $menuDayPrice = $menuDishes->getMenuDayPrice($this->dbcon);


            /** We obtain the dishe info to show */           
            $dishe = $menuDishes->selectOneByIdInnerjoinOnfield("dishes", "dishes_menu","menu_id", "dishe_id", $_SESSION['dishe_id'], $this->dbcon);
            $description = $commonTask->divideTextInParagrahs($dishe['description']);
            $dishe_picture = $commonTask->getWebPath($dishe['picture']) ?? $dishe['picture'] = "";                                   

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
            $pdf->SetFillColor(0, 54.5, 54.5);           
            $pdf->AddPage();
            $pdf->AliasNbPages();
            //$pdf->SetFont('Arial','B',12);           
            $pdf->SetFont('GreatVibes','',18);  


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
                    //$pdf->SetFont('Arial','I',10);
                    $pdf->SetFont('GreatVibes','',14);

                    if($value['available'] == true) {
                        $pdf->Cell(150, 10, iconv('UTF-8', 'ISO-8859-1', ucfirst($value['name'])), 0, 0, 'L');
                        $pdf->SetFont('GreatVibes','',11);
                        $pdf->Cell(20, 10, $value['price'] . " " . EURO_SIMBOL, 0, 0, 'R');
                        $pdf->Ln(5);                                                                                        
                    }
                    
                    //$pdf->SetFont('Arial','B',12);
                    $pdf->SetFont('GreatVibes','',18); 
                }

                $pdf->Ln(20);
            }            
            
            $pdf->Output('', 'Menu.pdf');            
        }
    }
    
?>