<?php
    declare(strict_types=1);   
    
    namespace Application\Controller\admin;

    use Application\Core\Controller;
    use model\classes\Language;
    use model\classes\Query;
    use model\orders\Order;
    use model\repositories\OrderRepository;

    class ComandasController extends Controller
    {        
        /** Create arrays for diferent sections to show */

        private array $aperitifs          = [];
        private array $aperitifs_qty      = [];
        private array $aperitifs_finished = [];
        private array $firsts             = [];
        private array $firsts_qty         = [];
        private array $firsts_finished    = [];
        private array $seconds            = [];
        private array $seconds_qty        = [];
        private array $seconds_finished   = [];
        private array $desserts           = [];
        private array $desserts_qty       = [];
        private array $desserts_finished  = [];
        private array $drinks             = [];
        private array $drinks_qty         = [];
        private array $drinks_finished    = [];
        private array $coffees            = [];
        private array $coffees_qty        = [];
        private array $coffees_finished   = [];


        /** Create array and object for diferent languages */

        private array $language = [];
        private Language $languageObject;

        public function __construct(            
            private string $message = "",
            private array $fields = [],
            private Query $query = new Query(),
            private OrderRepository $orderRepository = new OrderRepository()
        )
        {
            $this->languageObject = new Language();

            /** Test page language */
            $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();	
        }

       
        /**
         * This PHP function retrieves data from a database and converts string fields into arrays,
         * then creates an array of elements to be displayed in an admin view.
         * 
         * @param string message A string parameter that can be passed to the function as an argument.
         * If no argument is passed, it defaults to an empty string.
         */
        
        public function index(): void    
        {  
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            $_SESSION['action'] = "index";
            unset($_SESSION['message']);                                              

            try {                
                $result = $this->query->selectAll('orders');
                
                $this->render('/view/admin/comandas/index_view.php', [
                    'message' => $this->message,
                    'fields' => $this->fields,
                    'result' => $result
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
                
                $this->render('/view/database_error', [
                    'message' => $this->message
                ]);
            }                              
        }


        public function show(): void
        {  
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);            
            
            $_SESSION['action'] = "show";
            $_SESSION['id'] = isset($_POST['id']) ? $_POST['id'] : $_SESSION['id'];                

            try {                
                $result = $this->query->selectAllBy('orders', 'id', $_SESSION['id']);
                $row   = []; 

                $id           = $result[0]['id'];
                $table_number = $result[0]['table_number'];
                $people_qty   = $result[0]['people_qty'];

                $this->aperitifs         [0] = (explode(",", $result[0]['aperitifs']));
                $this->aperitifs_qty     [0] = (explode(",", $result[0]['aperitifs_qty']));
                $this->aperitifs_finished[0] = (explode(",", $result[0]['aperitifs_finished']));
                $this->firsts            [0] = (explode(",", $result[0]['firsts']));
                $this->firsts_qty        [0] = (explode(",", $result[0]['firsts_qty']));
                $this->firsts_finished   [0] = (explode(",", $result[0]['firsts_finished'])); 
                $this->seconds           [0] = (explode(",", $result[0]['seconds']));
                $this->seconds_qty       [0] = (explode(",", $result[0]['seconds_qty']));
                $this->seconds_finished  [0] = (explode(",", $result[0]['seconds_finished'])); 
                $this->desserts          [0] = (explode(",", $result[0]['desserts']));
                $this->desserts_qty      [0] = (explode(",", $result[0]['desserts_qty']));
                $this->desserts_finished [0] = (explode(",", $result[0]['desserts_finished'])); 
                $this->drinks            [0] = (explode(",", $result[0]['drinks']));
                $this->drinks_qty        [0] = (explode(",", $result[0]['drinks_qty']));
                $this->drinks_finished   [0] = (explode(",", $result[0]['drinks_finished'])); 
                $this->coffees           [0] = (explode(",", $result[0]['coffees']));
                $this->coffees_qty       [0] = (explode(",", $result[0]['coffees_qty']));
                $this->coffees_finished  [0] = (explode(",", $result[0]['coffees_finished']));                

                $row[0] = [
                    'id'                 =>  $id,
                    'table_number'       =>  $table_number,
                    'people_qty'         =>  $people_qty,
                    'aperitifs'          =>  $this->aperitifs,
                    'aperitifs_finished' =>  $this->aperitifs_finished,
                    'aperitifs_qty'      =>  $this->aperitifs_qty,
                    'firsts_finished'    =>  $this->firsts_finished,
                    'firsts'             =>  $this->firsts,
                    'firsts_qty'         =>  $this->firsts_qty,
                    'seconds'            =>  $this->seconds,
                    'seconds_qty'        =>  $this->seconds_qty,
                    'seconds_finished'   =>  $this->seconds_finished,
                    'desserts'           =>  $this->desserts,
                    'desserts_qty'       =>  $this->desserts_qty,
                    'desserts_finished'  =>  $this->desserts_finished,
                    'drinks'             =>  $this->drinks,
                    'drinks_qty'         =>  $this->drinks_qty,
                    'drinks_finished'    =>  $this->drinks_finished,
                    'coffees'            =>  $this->coffees,
                    'coffees_qty'        =>  $this->coffees_qty,
                    'coffees_finished'   =>  $this->coffees_finished,
                ];                   
                
                $this->render('/view/admin/comandas/show_view.php', [
                    'message' => $this->message,
                    'fields' => $this->fields,
                    'row' => $row
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
         * This function creates arrays for table numbers and people quantity, saves dish information
         * into an order array, and displays a new order view.
         * 
         * @param array variables An optional array of variables that can be passed to the function. It
         * is not used in this function.
         */
        public function add(): void
        {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);
                        
            /** Configure order options */
            if((isset($_SESSION['table_number']) || isset($_SESSION['people_qty'])) && (strlen($_SESSION['table_number']) > MAX_DIGITS_TO_TABLE_NUMBERS && strlen($_SESSION['people_qty']) > MAX_DIGITS_TO_TABLE_NUMBERS)) {			                
                $table_number = isset($_POST['table_number']) ? $_POST['table_number'] : ucfirst($this->language[strtolower($_SESSION['table_number'])]);	
                $people_qty = isset($_POST['people_qty']) ? $_POST['people_qty'] : ucfirst($this->language[strtolower($_SESSION['people_qty'])]);		
                $id = isset($_POST['id']) ? $_POST['id'] : $_SESSION['id'];                	
            }
            else {
                $table_number = isset($_POST['table_number']) ? $_POST['table_number'] : $_SESSION['table_number'] ?? "";	
                $people_qty = isset($_POST['people_qty']) ? $_POST['people_qty'] : $_SESSION['people_qty'] ?? "";		
                $id = isset($_POST['id']) ? $_POST['id'] : $_SESSION['id'] ?? "";                	
            }
            
            $variables = [
                'table_number'	=>	$table_number,
                'people_qty'	=>	$people_qty,
                'id'			=>	$id,
                'action'		=>	"add",				
            ];           

            $_SESSION['id'] = $variables['id'] ?? "";

            if(isset($variables['action'])) $_SESSION['action'] = $variables['action'];                        
                        
            try {
                /** Test page language */
                $_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];                


                /** Configure page language */
			    $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();                                                        


                /** Show text in 'Select' elements, table number or people quantity */ 
                if(isset($_POST['language'])) {                                                          
                    $_SESSION['table_number'] = strlen($_SESSION['table_number']) > MAX_DIGITS_TO_TABLE_NUMBERS ? ucfirst($this->language['select']) : $_SESSION['table_number'] ;
                    $_SESSION['people_qty'] = strlen($_SESSION['people_qty']) > MAX_DIGITS_TO_PEOPLE_QTY ? ucfirst($this->language['select']) : $_SESSION['people_qty'] ;
                }

                if(isset($variables['table_number'])) $_SESSION['table_number'] = $variables['table_number'];
                if(isset($variables['people_qty'])) $_SESSION['people_qty'] = $variables['people_qty'];
                if(!isset($_SESSION['table_number'])) $_SESSION['table_number'] = ucfirst($this->language['select']);
                if(!isset($_SESSION['people_qty'])) $_SESSION['people_qty'] = ucfirst($this->language['select']);                

                                                                                                
                /** Get dish`s name, qty and position and save them into $_SESSION['order'] array */                

                $_SESSION['order'][] = [
                    'name'      =>  $_POST['name'] ?? "",
                    'qty'       =>  $_POST['qty'] ?? 0,
                    'position'  =>  $_POST['place'] ?? "", 
                ];                

                foreach ($_SESSION['order'] as $item) { 
                    if($item['position']) {
                        match($item['position']) {
                            'aperitifs'  =>  $this->aperitifs[] = $item,
                            'firsts'     =>  $this->firsts[] = $item,
                            'seconds'    =>  $this->seconds[] = $item,
                            'desserts'   =>  $this->desserts[] = $item,
                            'drinks'     =>  $this->drinks[] = $item,
                            'coffees'    =>  $this->coffees[] = $item,
                        };
                    }                                      
                }                 
                                
                /** Create arrays for table`s numbers and people quantity to show in 'Select' elements in order view*/ 

                $tables = $persones = [];

                for($i = 1; $i <= 20; $i++) $tables[] = $i;
                for($i = 1; $i <= 40; $i++) $persones[] = $i;
                               
                $this->render('/view/admin/comandas/add_to_order.php', [
                    'tables' => $tables,
                    'persones' => $persones,
                    'aperitifs' => $this->aperitifs,
                    'firsts' => $this->firsts,
                    'seconds' => $this->seconds,
                    'desserts' => $this->desserts,
                    'drinks' => $this->drinks,
                    'coffees' => $this->coffees,
                    'message' => $this->message
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
         * This function updates an order in the database based on the values submitted through a form.
         */
        public function update(array $array = null): void
        {  
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);                        
            
            $order = new Order();           
            
            $id = !empty($_POST['id']) ? intval($_POST['id']) : "";                                   

            try { 
                if(!empty($id)) {                    
                    /** We set the order to update */
                    $order->setId($id);
                    $order->setAperitif($_POST['aperitifs_name']             ?? []); 
                    $order->setAperitifQty($_POST['aperitifs_qty']           ?? []);
                    $order->setAperitifFinished($_POST['aperitifs_finished'] ?? []);               
                    $order->setFirst($_POST['firsts_name']                   ?? []);
                    $order->setFirstQty($_POST['firsts_qty']                 ?? []);
                    $order->setFirstFinished($_POST['firsts_finished']       ?? []);                   
                    $order->setSecond($_POST['seconds_name']                 ?? []);
                    $order->setSecondQty($_POST['seconds_qty']               ?? []);
                    $order->setSecondFinished($_POST['seconds_finished']     ?? []);   
                    $order->setDessert($_POST['desserts_name']               ?? []); 
                    $order->setDessertQty($_POST['desserts_qty']             ?? []);
                    $order->setDessertFinished($_POST['desserts_finished']   ?? []);
                    $order->setDrink($_POST['drinks_name']                   ?? []);
                    $order->setDrinkQty($_POST['drinks_qty']                 ?? []); 
                    $order->setDrinkFinished($_POST['drinks_finished']       ?? []); 
                    $order->setCoffee($_POST['coffees_name']                 ?? []);
                    $order->setCoffeeQty($_POST['coffees_qty']               ?? []);
                    $order->setCoffeeFinished($_POST['coffees_finished']     ?? []);
                                       
                    /** Update the order */
                    $this->orderRepository->updateOrder($order);                                        
                }                           
                
                $_SESSION['message'] = "<p class='alert alert-success text-center'>Order update successfully</p>";                
                header("Location: /admin/comandas/show");                           

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
         * This PHP function deletes an order from the "orders" table in a database and displays a
         * success or error message.
         */
        public function delete(): void
        {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);
            
            $id = isset($_POST['id']) ? $_POST['id'] : "";            
            
            try {
                if($id) {
                    $this->orderRepository->deleteRegistry("orders", "id", $id);
                    $this->message = "<p class='alert alert-success text-center'>Order deleted!</p>";                    
                } 
                
                $this->index();
                
            } catch (\Throwable $th) {
                $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }
                
                $this->index();
            }
        }
        
        
        public function addToOrder(array $variables = []): void
        {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);
                        
            $order = new Order();            
        
            $id = $_POST['id'];

            $result = $this->query->selectOneBy('orders', 'id', $id); 


            /* Update the table_number and people_qty if they are different */
            
            if($_POST['table_number'] !== $result['table_number']) {
                $this->query->updateRow('orders', ['table_number' => $_POST['table_number']], $id);
            }

            if($_POST['people_qty'] !== $result['people_qty']) {
                $this->query->updateRow('orders', ['people_qty' => $_POST['people_qty']], $id);
            }
        

            /* We convert strings fields in arrays fields with their values */                                              

            $this->aperitifs          = (explode(",", $result['aperitifs']));
            $this->aperitifs_qty      = (explode(",", $result['aperitifs_qty']));
            $this->aperitifs_finished = (explode(",", $result['aperitifs_finished']));
            $this->firsts             = (explode(",", $result['firsts']));
            $this->firsts_qty         = (explode(",", $result['firsts_qty']));
            $this->firsts_finished    = (explode(",", $result['firsts_finished']));
            $this->seconds            = (explode(",", $result['seconds']));
            $this->seconds_qty        = (explode(",", $result['seconds_qty']));
            $this->seconds_finished   = (explode(",", $result['seconds_finished']));
            $this->desserts           = (explode(",", $result['desserts']));
            $this->desserts_qty       = (explode(",", $result['desserts_qty']));
            $this->desserts_finished  = (explode(",", $result['desserts_finished']));
            $this->drinks             = (explode(",", $result['drinks']));
            $this->drinks_qty         = (explode(",", $result['drinks_qty']));
            $this->drinks_finished    = (explode(",", $result['drinks_finished']));
            $this->coffees            = (explode(",", $result['coffees']));
            $this->coffees_qty        = (explode(",", $result['coffees_qty']));
            $this->coffees_finished   = (explode(",", $result['coffees_finished']));             

            $my_array = [
                'aperitifs'          =>  $_POST['aperitifs_name'] ?? [],
                'aperitifs_qty'      =>  $_POST['aperitifs_qty'] ?? [],
                'aperitifs_finished' =>  $_POST['aperitifs_finished'] ?? [],
                'firsts'             =>  $_POST['firsts_name'] ?? [],
                'firsts_qty'         =>  $_POST['firsts_qty'] ?? [],
                'firsts_finished'    =>  $_POST['firsts_finished'] ?? [],
                'seconds'            =>  $_POST['seconds_name'] ?? [],
                'seconds_qty'        =>  $_POST['seconds_qty'] ?? [],
                'seconds_finished'   =>  $_POST['seconds_finished'] ?? [],
                'desserts'           =>  $_POST['desserts_name'] ?? [],
                'desserts_qty'       =>  $_POST['desserts_qty'] ?? [],
                'desserts_finished'  =>  $_POST['desserts_finished'] ?? [],
                'drinks'             =>  $_POST['drinks_name'] ?? [],
                'drinks_qty'         =>  $_POST['drinks_qty'] ?? [],
                'drinks_finished'    =>  $_POST['drinks_finished'] ?? [],
                'coffees'            =>  $_POST['coffees_name'] ?? [],
                'coffees_qty'        =>  $_POST['coffees_qty'] ?? [],
                'coffees_finished'   =>  $_POST['coffees_finished'] ?? [],
            ];

            foreach ($my_array as $key => $value) {
                if(empty($value)) continue;                                              
                $this->$key = array_merge($this->$key, $value);               
            }       
                     
            $order->setId(intval($id));
            $order->setAperitif($this->aperitifs); 
            $order->setAperitifQty($this->aperitifs_qty);
            $order->setAperitifFinished($this->aperitifs_finished);              
            $order->setFirst($this->firsts);
            $order->setFirstQty($this->firsts_qty); 
            $order->setFirstFinished($this->firsts_finished);                   
            $order->setSecond($this->seconds);
            $order->setSecondQty($this->seconds_qty);
            $order->setSecondFinished($this->seconds_finished);
            $order->setDessert($this->desserts); 
            $order->setDessertQty($this->desserts_qty);
            $order->setDessertFinished($this->desserts_finished);
            $order->setDrink($this->drinks);
            $order->setDrinkQty($this->drinks_qty);
            $order->setDrinkFinished($this->drinks_finished); 
            $order->setCoffee($this->coffees);
            $order->setCoffeeQty($this->coffees_qty);
            $order->setCoffeeFinished($this->coffees_finished);
            
            try {
                /** Update the order */

                $this->orderRepository->updateOrder($order);
                $this->message = "<p class='alert alert-success text-center'>Order update successfully</p>";                
                $this->resetOrder();

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
        * This PHP function resets the order by unsetting the session variable and calling the "new"
        * function.
        */
        public function resetOrder(): void {                   
            try {
                unset($_SESSION['order']); 
                
                $_SESSION['table_number'] = ucfirst($this->language['selecciona']);
                $_SESSION['people_qty']   = ucfirst($this->language['selecciona']);
    
                $this->index($this->message);

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
         * This function updates the session with new table number, people quantity, and different
         * products selected by the user, and then displays them in a view.
         */
        public function updateAddList(): void
        {
            unset($_SESSION['order']);

            $_SESSION['action'] = "new";

            /** Get table number, people qty and different products */ 

            $_SESSION['table_number'] = isset($_POST['table_number']) ? $_POST['table_number'] : $_SESSION['table_number'];
            $_SESSION['people_qty'] = isset($_POST['people_qty']) ? $_POST['people_qty'] : $_SESSION['people_qty'];
            
            $this->aperitifs = $_POST['aperitifs_name'] ?? [];
            $this->aperitifs_qty = $_POST['aperitif_qty'] ?? [];
            $this->firsts = $_POST['firsts_name'] ?? [];
            $this->firsts_qty = $_POST['firsts_qty'] ?? [];
            $this->seconds = $_POST['seconds_name'] ?? []; 
            $this->seconds_qty = $_POST['seconds_qty'] ?? [];
            $this->desserts = $_POST['desserts_name'] ?? []; 
            $this->desserts_qty = $_POST['desserts_qty'] ?? [];  
            $this->drinks = $_POST['drinks_name'] ?? []; 
            $this->drinks_qty = $_POST['drinks_qty'] ?? []; 
            $this->coffees = $_POST['coffees_name'] ?? []; 
            $this->coffees_qty = $_POST['coffees_qty'] ?? [];
            
            $items = [
                "aperitifs"   =>  $this->aperitifs, 
                "firsts"   =>  $this->firsts,
                "seconds"   =>  $this->seconds, 
                "desserts"   =>  $this->desserts, 
                "drinks"   =>  $this->drinks,  
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
                    $_SESSION['people_qty'] = strlen($_SESSION['people_qty']) > MAX_DIGITS_TO_PEOPLE_QTY ? ucfirst($this->language['select']) : $_SESSION['people_qty'] ;
                }

                if(isset($variables['table_number'])) $_SESSION['table_number'] = $variables['table_number'];
                if(isset($variables['people_qty'])) $_SESSION['people_qty'] = $variables['people_qty'];
                if(!isset($_SESSION['table_number'])) $_SESSION['table_number'] = ucfirst($this->language['select']);
                if(!isset($_SESSION['people_qty'])) $_SESSION['people_qty'] = ucfirst($this->language['select']);  


                /** Test products to update them before send them to the DB */

                foreach ($items as $key => $value) {                                           
                    $count = isset($items[$key]) ? count($items[$key]) : 0;
                    
                    for ($i=0; $i < $count; $i++) {
                        if($_POST["{$key}_qty"][$i] < 1) continue;                     
        
                        $_SESSION['order'][] = [
                            'name'      =>  $_POST["{$key}_name"][$i] ?? "",
                            'qty'       =>  $_POST["{$key}_qty"][$i] ?? 0,
                            'position'  =>  $key ?? "", 
                        ];
                    }
                } 

                if(isset($_SESSION['order'])) {
                    foreach ($_SESSION['order'] as $item) { 
                        if($item['position']) {
                            match($item['position']) {
                                'aperitifs'  =>  $this->aperitifs[] = $item,
                                'firsts'     =>  $this->firsts[] = $item,
                                'seconds'    =>  $this->seconds[] = $item,
                                'desserts'   =>  $this->desserts[] = $item,
                                'drinks'     =>  $this->drinks[] = $item,
                                'coffees'    =>  $this->coffees[] = $item,
                            };
                        }                                      
                    }
                }                             
                 

                /** Create arrays for table`s numbers and people quantity to show in 'Select' elements in order view*/ 

                $tables = $persones = [];

                for($i = 1; $i <= 20; $i++) $tables[] = $i;
                for($i = 1; $i <= 40; $i++) $persones[] = $i;

                //include(SITE_ROOT . "/../Application/view/admin/comandas/add_to_order.php");
                $this->render("/view/admin/comandas/add_to_order.php", [                    
                    'tables' => $tables,
                    'persones' => $persones,                                        
                    'aperitifs' => $this->aperitifs,
                    'firsts' => $this->firsts,
                    'seconds' => $this->seconds,
                    'desserts' => $this->desserts,
                    'drinks' => $this->drinks,
                    'coffees' => $this->coffees,                    
                    'message' => $this->message
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
    }
?>