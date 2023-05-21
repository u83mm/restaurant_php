<?php
    declare(strict_types=1);
    
    namespace Controller\admin;

    use Controller\orders\OrderController;
    use model\classes\Query;
    use model\orders\Order;
    use model\repositories\OrderRepository;

    class ComandasController
    {
        /** Create arrays for diferent sections to show */

        private array $aperitifs     = [];
        private array $aperitifs_qty = [];
        private array $firsts        = [];
        private array $firsts_qty    = [];
        private array $seconds       = [];
        private array $seconds_qty   = [];
        private array $desserts      = [];
        private array $desserts_qty  = [];
        private array $drinks        = [];
        private array $drinks_qty    = [];
        private array $coffees       = [];
        private array $coffees_qty   = [];

        public function __construct(
            private object $dbcon, 
            private string $message = "")
        {
            
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
            $this->message = $message ?? "";

            $query  = new Query();
            
            $fields = [
                'id',
                "table_number",
                "people_qty"
            ];

            try {
                $result = $query->selectFieldsFromTableOrderByField('orders', $fields, 'table_number', $this->dbcon);

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
            try {
                $query = new Query();

                $result = $query->selectAllBy('orders', 'id', $_POST['id'], $this->dbcon);
                $row   = []; 

                $id           = $result[0]['id'];
                $table_number = $result[0]['table_number'];
                $people_qty   = $result[0]['people_qty'];

                $this->aperitifs    [0] = (explode(",", $result[0]['aperitifs']));
                $this->aperitifs_qty[0] = (explode(",", $result[0]['aperitifs_qty']));
                $this->firsts       [0] = (explode(",", $result[0]['firsts']));
                $this->firsts_qty   [0] = (explode(",", $result[0]['firsts_qty']));
                $this->seconds      [0] = (explode(",", $result[0]['seconds']));
                $this->seconds_qty  [0] = (explode(",", $result[0]['seconds_qty']));
                $this->desserts     [0] = (explode(",", $result[0]['desserts']));
                $this->desserts_qty [0] = (explode(",", $result[0]['desserts_qty']));
                $this->drinks       [0] = (explode(",", $result[0]['drinks']));
                $this->drinks_qty   [0] = (explode(",", $result[0]['drinks_qty']));
                $this->coffees      [0] = (explode(",", $result[0]['coffees']));
                $this->coffees_qty  [0] = (explode(",", $result[0]['coffees_qty']));                

                $row[0] = [
                    'id'            =>  $id,
                    'table_number'  =>  $table_number,
                    'people_qty'    =>  $people_qty,
                    'aperitifs'     =>  $this->aperitifs,
                    'aperitifs_qty' =>  $this->aperitifs_qty,
                    'firsts'        =>  $this->firsts,
                    'firsts_qty'    =>  $this->firsts_qty,
                    'seconds'       =>  $this->seconds,
                    'seconds_qty'   =>  $this->seconds_qty,
                    'desserts'      =>  $this->desserts,
                    'desserts_qty'  =>  $this->desserts_qty,
                    'drinks'        =>  $this->drinks,
                    'drinks_qty'    =>  $this->drinks_qty,
                    'coffees'       =>  $this->coffees,
                    'coffees_qty'   =>  $this->coffees_qty,
                ];   
                //var_dump($result);die;

                include(SITE_ROOT . "/../view/admin/comandas/show_view.php");
                //throw new \Exception("Error Processing Request", 1);
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
                $order->setAperitif($_POST['aperitifs_name']   ?? []); 
                $order->setAperitifQty($_POST['aperitifs_qty'] ?? []);              
                $order->setFirst($_POST['firsts_name']         ?? []);
                $order->setFirstQty($_POST['firsts_qty']       ?? []);                   
                $order->setSecond($_POST['seconds_name']       ?? []);
                $order->setSecondQty($_POST['seconds_qty']     ?? []);
                $order->setDessert($_POST['desserts_name']     ?? []); 
                $order->setDessertQty($_POST['desserts_qty']   ?? []);
                $order->setDrink($_POST['drinks_name']         ?? []);
                $order->setDrinkQty($_POST['drinks_qty']       ?? []); 
                $order->setCoffee($_POST['coffees_name']       ?? []);
                $order->setCoffeeQty($_POST['coffees_qty']     ?? []);

                
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
        
        
        public function addToOrder(): void
        {
            $query = new Query();
            $order = new Order();
            $orderRepository = new OrderRepository();

            $id = $_POST['id'];

            $result = $query->selectOneBy('orders', 'id', $id, $this->dbcon);                                                    
        

            /* We convert strings fields in arrays fields with their values */

            $table_number = $result['table_number'];
            $people_qty   = $result['people_qty'];
                                  

            $this->aperitifs     = (explode(",", $result['aperitifs']));
            $this->aperitifs_qty = (explode(",", $result['aperitifs_qty']));
            $this->firsts        = (explode(",", $result['firsts']));
            $this->firsts_qty    = (explode(",", $result['firsts_qty']));
            $this->seconds       = (explode(",", $result['seconds']));
            $this->seconds_qty   = (explode(",", $result['seconds_qty']));
            $this->desserts      = (explode(",", $result['desserts']));
            $this->desserts_qty  = (explode(",", $result['desserts_qty']));
            $this->drinks        = (explode(",", $result['drinks']));
            $this->drinks_qty    = (explode(",", $result['drinks_qty']));
            $this->coffees       = (explode(",", $result['coffees']));
            $this->coffees_qty   = (explode(",", $result['coffees_qty']));             

            $my_array = [
                'aperitifs'     =>  $_POST['aperitifs_name'] ?? [],
                'aperitifs_qty' =>  $_POST['aperitifs_qty'] ?? [],
                'firsts'        =>  $_POST['firsts_name'] ?? [],
                'firsts_qty'    =>  $_POST['firsts_qty'] ?? [],
                'seconds'       =>  $_POST['seconds_name'] ?? [],
                'seconds_qty'   =>  $_POST['seconds_qty'] ?? [],
                'desserts'      =>  $_POST['desserts_name'] ?? [],
                'desserts_qty'  =>  $_POST['desserts_qty'] ?? [],
                'drinks'        =>  $_POST['drinks_name'] ?? [],
                'drinks_qty'    =>  $_POST['drinks_qty'] ?? [],
                'coffees'       =>  $_POST['coffees_name'] ?? [],
                'coffees_qty'   =>  $_POST['coffees_qty'] ?? [],
            ];

            foreach ($my_array as $key => $value) {
                if(empty($value)) continue;                                              
                $this->$key = array_merge($this->$key, $value);               
            }       
                     
            $order->setId(intval($id));
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
            unset($_SESSION['order']);
            unset($_SESSION['table_number']);
            unset($_SESSION['people_qty']);                        

            $this->index($this->message);
        }
    }
?>