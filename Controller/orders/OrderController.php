<?php
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

        public function __construct(private object $dbcon, private $message = "")
        {
                        
        }
      
        public function new(array $variables = null): void
        {
            try {
                $table_number = $variables['table'] ?? "- Selecciona -";
                $people_qty = $variables['people'] ?? "- Selecciona -"; 


                /** Get dish`s name, qty and position and save them into $_SESSION['order'] array */                

                $_SESSION['order'][] = [
                    'name'      =>  $_POST['name'] ?? "",
                    'qty'       =>  $_POST['qty'] ?? 0,
                    'position'  =>  $_POST['place'] ?? "", 
                ];                

                foreach ($_SESSION['order'] as $item) { 
                    if($item['position']) {
                        match($item['position']) {
                            'aperitif'  =>  $this->aperitifs[] = $item,
                            'first'     =>  $this->firsts[] = $item,
                            'second'    =>  $this->seconds[] = $item,
                            'dessert'   =>  $this->desserts[] = $item,
                            'drink'     =>  $this->drinks[] = $item,
                            'coffee'    =>  $this->coffees[] = $item,
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

        public function save(): void
        {      
            /** Get table number and people qty */ 

            $table_number = $_POST['table_number'];
            $people_qty = $_POST['people_qty'];
            
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

            try {
                if($table_number === "- Selecciona -") throw new \Exception("Selecciona un número de mesa", 1);
                if($people_qty === "- Selecciona -") throw new \Exception("Selecciona un número de personas", 1); 


                /** we set an order */

                $order = new Order();
                $orderRepository = new OrderRepository();                

                $order->setTable($table_number);
                $order->setPeople($people_qty); 
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
                    'table'     => $table_number,
                    'people'    => $people_qty,
                ]);
            }
        }

        
       /**
        * This PHP function resets the order by unsetting the session variable and calling the "new"
        * function.
        */
        public function resetOrder(): void {        
            unset($_SESSION['order']);
            $this->new();							  			                       
        }
    }    
?>  