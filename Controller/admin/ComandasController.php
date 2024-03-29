<?php
    declare(strict_types=1);
    
    namespace Controller\admin;

    use model\classes\Language;
    use model\classes\Query;
    use model\orders\Order;
    use model\repositories\OrderRepository;

    class ComandasController
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
            private object $dbcon = DB_CON, 
            private string $message = "")
        {
            $this->languageObject = new Language();
        }

       
        /**
         * This PHP function retrieves data from a database and converts string fields into arrays,
         * then creates an array of elements to be displayed in an admin view.
         * 
         * @param string message A string parameter that can be passed to the function as an argument.
         * If no argument is passed, it defaults to an empty string.
         */
        
        public function index(string $message = null): void    
        {  
            $_SESSION['action'] = "index";

            $this->message = $message ?? "";

            $query  = new Query();
            
            $fields = [
                'id',
                "table_number",
                "people_qty"
            ];

            try {                
                $result = $query->selectAll('orders', $this->dbcon);

                include(SITE_ROOT . "/../view/admin/comandas/index_view.php"); 

            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                $this->message = $error_msg;

                include(SITE_ROOT . "/../view/database_error.php");
            }                              
        }


        public function show(): void
        {  
            $_SESSION['action'] = "show";

            $_SESSION['id'] = isset($_POST['id']) ? $_POST['id'] : $_SESSION['id'];        

            try {
                $query = new Query();

                $result = $query->selectAllBy('orders', 'id', $_SESSION['id']);
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

                include(SITE_ROOT . "/../view/admin/comandas/show_view.php");
                                
            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                $this->message = $error_msg;

                include(SITE_ROOT . "/../view/database_error.php");
            }
        }


        /**
         * This function creates arrays for table numbers and people quantity, saves dish information
         * into an order array, and displays a new order view.
         * 
         * @param array variables An optional array of variables that can be passed to the function. It
         * is not used in this function.
         */
        public function add(array $variables = null): void
        {
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
                
                include(SITE_ROOT . "/../view/orders/new_view.php");                

            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                include(SITE_ROOT . "/../view/database_error.php");
            }
        }      


        /**
         * This function updates an order in the database based on the values submitted through a form.
         */
        public function update(array $array = null): void
        {  
            $order = new Order();
            $orderRepository = new OrderRepository();
            
            $id = intval($_POST['id']);                      

            try {                            
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

                $orderRepository->updateOrder($order, $this->dbcon);
                $this->message = "<p class='alert alert-success text-center'>Order update successfully</p>";                
                $this->show();               

            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                $this->message = $error_msg;

                include(SITE_ROOT . "/../view/database_error.php");
            }
        }

        
        /**
         * This PHP function deletes an order from the "orders" table in a database and displays a
         * success or error message.
         */
        public function delete(): void
        {
            $id = $_POST['id'];
            $orderRepository = new OrderRepository();
            
            try {
                $orderRepository->deleteRegistry("orders", "id", $id, $this->dbcon);
                $message = "<p class='alert alert-success text-center'>Order deleted!</p>";
                $this->index($message);
                
            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }
                
                $this->index($error_msg);
            }
        }
        
        
        public function addToOrder(array $variables = []): void
        {
            $query = new Query();
            $order = new Order();
            $orderRepository = new OrderRepository();

            $id = $_POST['id'];

            $result = $query->selectOneBy('orders', 'id', $id, $this->dbcon);                                                    
        

            /* We convert strings fields in arrays fields with their values */

            $table_number = $result['table_number'];
            $people_qty   = $result['people_qty'];
                                  

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

                $orderRepository->updateOrder($order, $this->dbcon);
                $this->message = "<p class='alert alert-success text-center'>Order update successfully</p>";                
                $this->resetOrder();

            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                $this->message = $error_msg;

                include(SITE_ROOT . "/../view/database_error.php");
            }
        }


        /**
        * This PHP function resets the order by unsetting the session variable and calling the "new"
        * function.
        */
        public function resetOrder(): void {                   
            try {
                unset($_SESSION['order']);                                       
    
                $this->index($this->message);

            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                } 
                
                include(SITE_ROOT . "/../view/database_error.php");
            }
        }             
    }
?>