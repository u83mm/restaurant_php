<?php  
    declare(strict_types=1);   

    use model\classes\CommonTasks;
    use model\classes\Language;
    use model\classes\QueryMenu;    
    use model\fpdf\MyPdf;

    class MenuController
    {
        private Language $languageObject;

        public function __construct(private object $dbcon = DB_CON, private array $language = [])      
        {
            $this->languageObject = new Language();

            /** Configure page language */           
			$this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();
        }

        /**
         * The function displays different menu categories and their dishes, and calculates the menu's
         * day price.
         */
        public function index(): void
        {                                            
            $menuDay = new QueryMenu(); 

            /** Get dishes, dessert and price to show in the Day's menu aside section */
            $menuDaySections = $menuDay->getMenuDayElements();

            /** Show Menu's categories */
            $menuCategories = $menuDay->selectAll("dishes_menu");            
            $showResult = "";

            for($i = 0, $y = 3; $i < count($menuCategories); $i++) {
                $category = ucfirst($this->language["{$menuCategories[$i]['menu_category']}"]);                
                $emoji = $menuCategories[$i]['menu_emoji'];
                
                $showResult .= "<li class='showMenuCategories'>
                                    <form class='d-inline' action='/menu/showDishesByTheirCategory' method='POST'>                                       
                                        <button class='btn btn-outline-secondary text-start' type='submit' name='category' value='$category'><span class='px-2 float-start'>$emoji</span>$category</button>
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
        public function showDishesByTheirCategory(string $category = null): void
        { 
            $category = $phrase = strtolower($_REQUEST['category']) ?? "";

            // Change category's language to spanish to do the query to the DB
            $this->language = $this->languageObject->spanish();
            $category = $this->language[$category];                       

            $menuDishes = new QueryMenu();                  

            /** Get dishes, dessert and price to show in the Day's menu aside section */
            $menuDaySections = $menuDishes->getMenuDayElements();
                       
            /** Show dishes */
            $rows = $menuDishes->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", $category);                   
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
            global $id;                       
            
            $_SESSION['dishe_id'] = isset($id) ? $id : null;                           
            $menuDishes = new QueryMenu();
            $commonTask = new CommonTasks(); 
                      

            /** Get dishes, dessert and price to show in the Day's menu aside section */
            $menuDaySections = $menuDishes->getMenuDayElements();


            /** We obtain the dishe info to show */           
            $dishe = $menuDishes->selectOneByIdInnerjoinOnfield("dishes", "dishes_menu","menu_id", "dishe_id", $_SESSION['dishe_id']);
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
            $menuCategories = $menu->selectAll("dishes_menu");    
            

            /** Start to build the menu */
           
            $pdf->title = ucwords($this->language['our_menu']);           
            $pdf->SetFillColor(0, 54.5, 54.5);           
            $pdf->AddPage();
            $pdf->AliasNbPages();                    
            $pdf->SetFont('GreatVibes','',18);  


            /** Show all the categories and their dishes*/

            foreach ($menuCategories as $key => $category) {                
                $pdf->Cell(150, 10, iconv('UTF-8', 'ISO-8859-1', ucfirst($this->language[$category['menu_category']])), 0, 0, '');
                $pdf->Cell(0, 10, ucfirst($this->language['price']), 0, 0, "");                
                //$pdf->Line(10, $pdf->getY()+10, $pdf->getX() -3, $pdf->GetY() + 10);
                $pdf->Rect(10, $pdf->getY()+10, 170, 2, "F");                                               
                $pdf->Ln(10);


                /** Show dishes */

                $rows = $menu->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", $category['menu_category']);                               

                foreach ($rows as $key => $value) {
                    //$pdf->SetFont('Arial','I',10);
                    $pdf->SetFont('GreatVibes','',14);

                    if($value['available'] == true) {
                        $pdf->Cell(150, 10, iconv('UTF-8', 'ISO-8859-1', ucfirst($this->language[$value['name']])), 0, 0, 'L');
                        $pdf->SetFont('GreatVibes','',11);
                        $pdf->Cell(20, 10, $value['price'] . " " . EURO_SIMBOL, 0, 0, 'R');
                        $pdf->Ln(5);                                                                                        
                    }
                                       
                    $pdf->SetFont('GreatVibes','',18); 
                }

                $pdf->Ln(20);
            }            
            
            $pdf->Output('', 'Menu.pdf');            
        }
    }
    
?>