<?php  
    declare(strict_types=1);

    namespace Application\Controller;

    use Application\Core\Controller;
    use model\classes\CommonTasks;
    use model\classes\Language;
    use model\classes\QueryMenu;    
    use model\fpdf\MyPdf;

    class MenuController extends Controller
    {
        private Language $languageObject;

        public function __construct(
            private object $dbcon = DB_CON, 
            private array $language = [],
            private QueryMenu $queryMenu = new QueryMenu()
        )      
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
            /** Get dishes, dessert and price to show in the Day's menu aside section */
            $menuDaySections = $this->queryMenu->getMenuDayElements();

            /** Show Menu's categories */
            $menuCategories = $this->queryMenu->selectAll("dishes_menu");            
            $showResult = "";            

            for($i = 0, $y = 3; $i < count($menuCategories); $i++) {
                $category = ucfirst($this->language["{$menuCategories[$i]['menu_category']}"]);                
                $emoji = $menuCategories[$i]['menu_emoji'];
                
                $showResult .= "<li class='showMenuCategories'>
                                    <form class='d-inline' action='/menu/showDishesByTheirCategory/{$menuCategories[$i]['menu_id']}' method='POST'>                                       
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
            
            $this->render("/view/menu/menu_view.php", [
                'showResult'        =>  $showResult,
                'menuDaySections'   =>  $menuDaySections               
            ]);
        }

        /**
         * This PHP function shows dishes by their category and calculates the menu day price.
         * 
         * @param string category The category of dishes to be shown.
         */
        public function showDishesByTheirCategory(string $category = null): void
        { 
            global $id;                        

            if(!isset($_REQUEST['category'])) {
                $rows = $this->queryMenu->selectFieldsFromTableById(
                    ['menu_category'], 
                    'dishes_menu', 
                    'menu_id', 
                    $id
                );
                 
                $category =  $rows['menu_category'];             
            }
            else {
                $category = strtolower($_REQUEST['category']) ?? ""; 
            }                                                        

            // Change category's language to spanish to do the query to the DB
            $this->language = $this->languageObject->spanish();
            $category = $this->language[$category];
                                        
            /** Get dishes, dessert and price to show in the Day's menu aside section */
            $menuDaySections = $this->queryMenu->getMenuDayElements();
                       
            /** Show dishes */
            $rows = $this->queryMenu->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", $category);                   
            $showResult = $this->queryMenu->showMenuListByCategory($rows, $category);                          
                     
            $this->render("/view/menu/category_view.php", [
                'menuDaySections'   =>  $menuDaySections,
                'category'          =>  $category,
                'showResult'        =>  $showResult
            ]);
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
            $commonTask = new CommonTasks(); 
                      
            /** Get dishes, dessert and price to show in the Day's menu aside section */
            $menuDaySections = $this->queryMenu->getMenuDayElements();

            /** We obtain the dishe info to show */           
            $dishe = $this->queryMenu->selectOneByFieldNameInnerjoinOnfield("dishes", "dishes_menu","menu_id", "dishe_id", $_SESSION['dishe_id']);
            $description = $commonTask->divideTextInParagrahs($dishe['description']);
            $dishe_picture = $commonTask->getWebPath($dishe['picture']) ?? $dishe['picture'] = "";                                   
            
            $this->render("/view/menu/show_dishe_view.php", [
                'dishe'             =>  $dishe,
                'description'       =>  $description,
                'dishe_picture'     =>  $dishe_picture,
                'menuDaySections'   =>  $menuDaySections
            ]);
        }

        /**
         * It creates a PDF file with the title "Nuestra Carta" and shows it in the browser.
         */
        public function menu(): void
        {               
            define('FPDF_FONTPATH', SITE_ROOT .'/../Application/model/fpdf/font');
            define('EURO_SIMBOL', chr(128));  
                               

            /** Create objects */
            $pdf = new MyPdf();            

                  
            /** We obtain Menu's categories */
            $menuCategories = $this->queryMenu->selectAll("dishes_menu");    
            

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
                $pdf->Rect(10, $pdf->getY()+10, 170, 2, "F");                                               
                $pdf->Ln(10);


                /** Show dishes */
                $rows = $this->queryMenu->selectAllInnerjoinByMenuCategory("dishes", "dishes_menu", "menu_id", $category['menu_category']);                               

                foreach ($rows as $key => $value) {                    
                    $pdf->SetFont('GreatVibes','',14);

                    if($value['available']) {
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