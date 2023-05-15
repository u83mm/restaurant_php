<?php
    declare(strict_types=1);
    
    namespace Controller\admin;

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

            $query = new Query();            

            $result = $query->selectAll('orders', $this->dbcon);
            $rows = [];                          
            

            /* We convert strings fields in arrays fields with their values and we make an array "rows" 
               with the different elements */

            for($i = 0; $i < count($result); $i++) { 
                $id = $result[$i]['id'];
                $table_number = $result[$i]['table_number'];
                $people_qty = $result[$i]['people_qty'];               
                $aperitifs[] = (explode(",", $result[$i]['aperitifs']));
                $aperitifs_qty[] = (explode(",", $result[$i]['aperitifs_qty']));
                $firsts[] = (explode(",", $result[$i]['firsts']));
                $firsts_qty[] = (explode(",", $result[$i]['firsts_qty']));
                $seconds[] = (explode(",", $result[$i]['seconds']));
                $seconds_qty[] = (explode(",", $result[$i]['seconds_qty']));
                $desserts[] = (explode(",", $result[$i]['desserts']));
                $desserts_qty[] = (explode(",", $result[$i]['desserts_qty']));
                $drinks[] = (explode(",", $result[$i]['drinks']));
                $drinks_qty[] = (explode(",", $result[$i]['drinks_qty']));
                $coffees[] = (explode(",", $result[$i]['coffees']));
                $coffees_qty[] = (explode(",", $result[$i]['coffees_qty']));                

                $rows[$i] = [
                    'id'            =>  $id,
                    'table_number'  =>  $table_number,
                    'people_qty'    =>  $people_qty,
                    'aperitifs'     =>  $aperitifs,
                    'aperitifs_qty' =>  $aperitifs_qty,
                    'firsts'        =>  $firsts,
                    'firsts_qty'    =>  $firsts_qty,
                    'seconds'       =>  $seconds,
                    'seconds_qty'   =>  $seconds_qty,
                    'desserts'      =>  $desserts,
                    'desserts_qty'  =>  $desserts_qty,
                    'drinks'        =>  $drinks,
                    'drinks_qty'    =>  $drinks_qty,
                    'coffees'       =>  $coffees,
                    'coffees_qty'   =>  $coffees_qty,
                ];                                               
            }
                        
            include(SITE_ROOT . "/../view/admin/comandas/admin_comandas_view.php");
        }


        /**
         * This function updates an order in the database based on the values submitted through a form.
         */
        public function update(): void
        {  
            $order = new Order  ();
            $orderRepository = new OrderRepository();
            
            $id = intval($_POST['id']);            

            try {                            
                /** We set the order to update */

                $order->setId($id);
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

                
                /** Update the order */

                $orderRepository->updateOrder($order, $this->dbcon);
                $this->message = "<p class='alert alert-success text-center'>Order update successfully</p>";
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
    }
?>