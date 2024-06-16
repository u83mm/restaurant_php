<?php
    declare(strict_types=1);

    use Application\Core\Controller;
    use model\classes\Language;
    use model\classes\Query;
    use model\orders\Order;
    use model\repositories\OrderRepository;

    class OrderController extends Controller
    {
        /** Create arrays for diferent sections to show */
        private array $aperitifs = [];
        private array $aperitifs_qty = [];
        private array $firsts = [];
        private array $firsts_qty = [];
        private array $seconds = [];
        private array $seconds_qty = [];
        private array $desserts = [];
        private array $desserts_qty = [];
        private array $drinks = [];
        private array $drinks_qty = [];
        private array $coffees = [];
        private array $coffees_qty = [];


        /** Create array and object for diferent languages */
        private array $language = [];
        private Language $languageObject;

        public function __construct(
            private object $dbcon = DB_CON, 
            private string $message = ""
        )
        {
            $this->languageObject = new Language();             
        }
      
        /**
         * This function creates arrays for table numbers and people quantity, saves dish information
         * into an order array, and displays a new order view.
         * 
         * @param array variables An optional array of variables that can be passed to the function. It
         * is not used in this function.
         */
        public function new(array $variables = null): void
        {            
            $_SESSION['id'] = $variables['id'] ?? "";
            $_SESSION['action'] = "new";

            if(isset($variables['action'])) $_SESSION['action'] = $variables['action'];                        
                        
            try {
                /** Test page language */
                $_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];                

                /** Configure page language */
			    $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();                                                        


                /** Show text in 'Select' elements, table number or people quantity */ 
                if(isset($_POST['language'])) {                                                          
                    $_SESSION['table_number'] = strlen($_SESSION['table_number']) > MAX_DIGITS_TO_TABLE_NUMBERS ? ucfirst($this->language['select']) : $_SESSION['table_number'] ;
                    $_SESSION['people_qty']   = strlen($_SESSION['people_qty'])   > MAX_DIGITS_TO_PEOPLE_QTY    ? ucfirst($this->language['select']) : $_SESSION['people_qty'] ;
                }

                if(isset($variables['table_number'])) $_SESSION['table_number'] = $variables['table_number'];
                if(isset($variables['people_qty']))   $_SESSION['people_qty']   = $variables['people_qty'];
                if(!isset($_SESSION['table_number'])) $_SESSION['table_number'] = ucfirst($this->language['select']);
                if(!isset($_SESSION['people_qty']))   $_SESSION['people_qty']   = ucfirst($this->language['select']);                

                                                                                                
                /** Get dish`s name, qty and position and save them into $_SESSION['order'] array */                
                $_SESSION['order'][] = [
                    'name'      =>  $_POST['name']  ?? "",
                    'qty'       =>  $_POST['qty']   ?? 0,
                    'position'  =>  $_POST['place'] ?? "", 
                ];                

                foreach ($_SESSION['order'] as $item) { 
                    if($item['position']) {
                        match($item['position']) {
                            'aperitifs'  =>  $this->aperitifs[] = $item,
                            'firsts'     =>  $this->firsts[]    = $item,
                            'seconds'    =>  $this->seconds[]   = $item,
                            'desserts'   =>  $this->desserts[]  = $item,
                            'drinks'     =>  $this->drinks[]    = $item,
                            'coffees'    =>  $this->coffees[]   = $item,
                        };
                    }                                      
                }                 
                                
                /** Create arrays for table`s numbers and people quantity to show in 'Select' elements in order view*/ 
                $tables = $persones = [];

                for($i = 1; $i <= 20; $i++) $tables[]   = $i;
                for($i = 1; $i <= 40; $i++) $persones[] = $i;
                                
                $this->render("/view/orders/new_view.php", [
                    'tables'    =>  $tables,
                    'persones'  =>  $persones,
                    'message'   =>  $this->message,
                    'aperitifs' =>  $this->aperitifs,
                    'firsts'    =>  $this->firsts,
                    'seconds'   =>  $this->seconds,
                    'desserts'  =>  $this->desserts,
                    'drinks'    =>  $this->drinks,
                    'coffees'   =>  $this->coffees
                ]);                

            } catch (\Throwable $th) {
                $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }
                
                $this->render("/view/database_error.php", [
                    'message' => $this->message
                ]);
            }
        }        

       /**
        * This function saves an order by getting the table number, people quantity, and various food
        * and drink items from a form, creating an order object, and saving it to a database through an
        * order repository.
        */
        public function save(): void
        {                         
            /** Test page language */
            $_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];                    


            /** Configure page language */
            $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();

        
            /** Get table number, people qty and different products */
            $_SESSION['table_number'] = $_POST['table_number'] >= 1 ? $_POST['table_number'] : ucfirst($this->language[strtolower($_POST['table_number'])]);
            $_SESSION['people_qty']   = $_POST['people_qty']   >= 1 ? $_POST['people_qty']   : ucfirst($this->language[$_POST['people_qty']]);         
                                            
            try {
                if($_SESSION['table_number'] === ucfirst($this->language['select'])) throw new \Exception(ucfirst($this->language['alert_table_number']), 1);
                if($_SESSION['people_qty']   === ucfirst($this->language['select'])) throw new \Exception(ucfirst($this->language['alert_people_qty']), 1);
                
                
                /** Test if the table is bussy */
                $query = new Query();
                $bussy_table = $query->selectOneBy('orders', 'table_number', $_SESSION['table_number']);
                if($bussy_table) throw new \Exception("Mesa ocupada", 1);
                

                /** we set an order */
                $order = new Order();                

                $comandasController = new ComandasController();
                $orderRepository = new OrderRepository();                

                $order->setTable(intval($_SESSION['table_number']));
                $order->setPeople(intval($_SESSION['people_qty'])); 
                $order->setAperitif($_POST['aperitifs_name'] ?? []); 
                $order->setAperitifQty($_POST['aperitifs_qty'] ?? []);              
                $order->setFirst($_POST['firsts_name'] ?? []);
                $order->setFirstQty($_POST['firsts_qty'] ?? []);                   
                $order->setSecond($_POST['seconds_name'] ?? []);
                $order->setSecondQty($_POST['seconds_qty'] ?? []);
                $order->setDessert($_POST['desserts_name'] ?? []); 
                $order->setDessertQty($_POST['desserts_qty'] ?? []);
                $order->setDrink($_POST['drinks_name'] ?? []);
                $order->setDrinkQty($_POST['drinks_qty'] ?? []); 
                $order->setCoffee($_POST['coffees_name'] ?? []);
                $order->setCoffeeQty($_POST['coffees_qty'] ?? []);                                            

                
                /** we save the order */                
                $orderRepository->saveOrder($order);
                $this->message = "<p class='alert alert-success text-center'>Order saved successfully</p>";
                $this->resetOrder();
                $comandasController->index($this->message);                                                            
                
            } catch (\Throwable $th) {                 
                $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }                                               

                $this->new([
                    'table_number'  => $_SESSION['table_number'],
                    'people_qty'    => $_SESSION['people_qty'],
                ]);
            }
        }


        /**
         * This function updates the session with new table number, people quantity, and different
         * products selected by the user, and then displays them in a view.
         */
        public function update(): void
        {
            unset($_SESSION['order']);

            $_SESSION['action'] = "new";


            /** Get table number, people qty and different products */ 
            $_SESSION['table_number'] = isset($_POST['table_number']) ? $_POST['table_number'] : $_SESSION['table_number'];
            $_SESSION['people_qty']   = isset($_POST['people_qty'])   ? $_POST['people_qty']   : $_SESSION['people_qty'];
            
            $this->aperitifs     = $_POST['aperitifs_name'] ?? [];
            $this->aperitifs_qty = $_POST['aperitif_qty']   ?? [];
            $this->firsts        = $_POST['firsts_name']    ?? [];
            $this->firsts_qty    = $_POST['firsts_qty']     ?? [];
            $this->seconds       = $_POST['seconds_name']   ?? []; 
            $this->seconds_qty   = $_POST['seconds_qty']    ?? [];
            $this->desserts      = $_POST['desserts_name']  ?? []; 
            $this->desserts_qty  = $_POST['desserts_qty']   ?? [];  
            $this->drinks        = $_POST['drinks_name']    ?? []; 
            $this->drinks_qty    = $_POST['drinks_qty']     ?? []; 
            $this->coffees       = $_POST['coffees_name']   ?? []; 
            $this->coffees_qty   = $_POST['coffees_qty']    ?? [];
            
            $items = [
                "aperitifs" =>  $this->aperitifs, 
                "firsts"    =>  $this->firsts,
                "seconds"   =>  $this->seconds, 
                "desserts"  =>  $this->desserts, 
                "drinks"    =>  $this->drinks,  
                "coffees"   =>  $this->coffees,            
            ];                                               
            

            try { 
                /** Test page language */
                $_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];                


                /** Configure page language */
			    $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();                                                        


                /** Show text in 'Select' elements, table number or people quantity */ 
                if(isset($_POST['language'])) {                                                          
                    $_SESSION['table_number'] = strlen($_SESSION['table_number']) > MAX_DIGITS_TO_TABLE_NUMBERS ? ucfirst($this->language['select']) : $_SESSION['table_number'] ;
                    $_SESSION['people_qty']   = strlen($_SESSION['people_qty'])   > MAX_DIGITS_TO_PEOPLE_QTY    ? ucfirst($this->language['select']) : $_SESSION['people_qty'] ;
                }

                if(isset($variables['table_number'])) $_SESSION['table_number'] = $variables['table_number'];
                if(isset($variables['people_qty'])) $_SESSION['people_qty']     = $variables['people_qty'];
                if(!isset($_SESSION['table_number'])) $_SESSION['table_number'] = ucfirst($this->language['select']);
                if(!isset($_SESSION['people_qty'])) $_SESSION['people_qty']     = ucfirst($this->language['select']);  


                /** Test products to update them before send them to the DB */
                foreach ($items as $key => $value) {                                           
                    $count = isset($items[$key]) ? count($items[$key]) : 0;
                    
                    for ($i=0; $i < $count; $i++) {
                        if($_POST["{$key}_qty"][$i] < 1) continue;                     
        
                        $_SESSION['order'][] = [
                            'name'      =>  $_POST["{$key}_name"][$i] ?? "",
                            'qty'       =>  $_POST["{$key}_qty"][$i]  ?? 0,
                            'position'  =>  $key ?? "", 
                        ];
                    }
                } 

                if(isset($_SESSION['order'])) {
                    foreach ($_SESSION['order'] as $item) { 
                        if($item['position']) {
                            match($item['position']) {
                                'aperitifs'  =>  $this->aperitifs[] = $item,
                                'firsts'     =>  $this->firsts[]    = $item,
                                'seconds'    =>  $this->seconds[]   = $item,
                                'desserts'   =>  $this->desserts[]  = $item,
                                'drinks'     =>  $this->drinks[]    = $item,
                                'coffees'    =>  $this->coffees[]   = $item,
                            };
                        }                                      
                    }
                }                             
                 

                /** Create arrays for table`s numbers and people quantity to show in 'Select' elements in order view*/ 
                $tables = $persones = [];

                for($i = 1; $i <= 20; $i++) $tables[]   = $i;
                for($i = 1; $i <= 40; $i++) $persones[] = $i;
                 
                $this->render('/view/orders/new_view.php', [
                    'tables'    =>  $tables,
                    'persones'  =>  $persones,
                    'message'   =>  $this->message,
                    'aperitifs' =>  $this->aperitifs,
                    'firsts'    =>  $this->firsts,
                    'seconds'   =>  $this->seconds,
                    'desserts'  =>  $this->desserts,
                    'drinks'    =>  $this->drinks,
                    'coffees'   =>  $this->coffees
                ]);                 
                
            } catch (\Throwable $th) {
                $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                } 
                                
                $this->render('/view/database_error.php', [
                    'message' => $this->message
                ]);
            }
        }

        
       /**
        * This PHP function resets the order by unsetting the session variable and calling the "new"
        * function.
        */
        public function resetOrder(): void {  
            try {                                
                unset($_SESSION['order']);                

                /** Test page language */
                $_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];                


                /** Configure page language */
                $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();                                                        

                $_SESSION['table_number'] = ucfirst($this->language['selecciona']);
                $_SESSION['people_qty']   = ucfirst($this->language['selecciona']);
                $this->new();

            } catch (\Throwable $th) {
                $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                } 
                                
                $this->render('/view/database_error.php', [
                    'message' => $this->message
                ]);
            }                  							  			                       
        }
    }    
?>  