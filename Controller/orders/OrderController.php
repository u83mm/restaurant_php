<?php
    declare(strict_types=1);
    
    namespace Controller\orders;
    
    use model\orders\Order;
    use model\repositories\OrderRepository;

    class OrderController
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

        public function __construct(
            private object $dbcon, 
            private string $message = "")
        {
                        
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
            try {
                $_SESSION['table_number'] = $variables['table_number'] ?? $_SESSION['table_number'] ?? "- Selecciona -";
                $_SESSION['people_qty'] = $variables['people_qty'] ?? $_SESSION['people_qty'] ?? "- Selecciona -"; 


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
        * This function saves an order by getting the table number, people quantity, and various food
        * and drink items from a form, creating an order object, and saving it to a database through an
        * order repository.
        */
        public function save(): void
        {      
            /** Get table number, people qty and different products */

            $_SESSION['table_number'] = $_POST['table_number'];
            $_SESSION['people_qty'] = $_POST['people_qty'];
            
            $this->aperitifs     =  $_POST['aperitifs_name'] ?? [];
            $this->aperitifs_qty =  $_POST['aperitifs_qty'] ?? [];
            $this->firsts        =  $_POST['firsts_name'] ?? [];
            $this->firsts_qty    =  $_POST['firsts_qty'] ?? [];
            $this->seconds       =  $_POST['seconds_name'] ?? []; 
            $this->seconds_qty   =  $_POST['seconds_qty'] ?? [];
            $this->desserts      =  $_POST['desserts_name'] ?? []; 
            $this->desserts_qty  =  $_POST['desserts_qty'] ?? [];  
            $this->drinks        =  $_POST['drinks_name'] ?? []; 
            $this->drinks_qty    =  $_POST['drinks_qty'] ?? []; 
            $this->coffees       =  $_POST['coffees_name'] ?? []; 
            $this->coffees_qty   =  $_POST['coffees_qty'] ?? [];            

            try {
                if($_SESSION['table_number'] === "- Selecciona -") throw new \Exception("Selecciona un número de mesa", 1);
                if($_SESSION['people_qty'] === "- Selecciona -") throw new \Exception("Selecciona un número de personas", 1); 


                /** we set an order */

                $order = new Order();
                $orderRepository = new OrderRepository();                

                $order->setTable(intval($_SESSION['table_number']));
                $order->setPeople(intval($_SESSION['people_qty'])); 
                $order->setAperitif($this->aperitifs); 
                $order->setAperitifQty($this->aperitifs_qty);              
                $order->setFirst($this->firsts);
                $order->setFirstQty($this->firsts_qty);                   
                $order->setSecond($this->seconds);
                $order->setSecondQty($this->seconds_qty);
                $order->setDessert($this->desserts); 
                $order->setDessertQty($this->desserts_qty);
                $order->setDrink($this->drinks);
                $order->setDrinkQty($this->drinks_qty); 
                $order->setCoffee($this->coffees);
                $order->setCoffeeQty($this->coffees_qty);                                            

                
                /** we save the order */
                
                $orderRepository->saveOrder($order, $this->dbcon);
                $this->message = "<p class='alert alert-success text-center'>Order saved successfully</p>";
                $this->resetOrder();
                $this->new();                                             
                
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


            /** Get table number, people qty and different products */ 

            $_SESSION['table_number'] = $_POST['table_number'];
            $_SESSION['people_qty'] = $_POST['people_qty'];
            
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
        * This PHP function resets the order by unsetting the session variable and calling the "new"
        * function.
        */
        public function resetOrder(): void {        
            unset($_SESSION['order']);
            unset($_SESSION['table_number']);
            unset($_SESSION['people_qty']);
            $this->new();							  			                       
        }
    }    
?>  