<?php
    namespace Controller\admin;

    use model\classes\Query;

    class ComandasController
    {
        public function __construct(private object $dbcon)
        {
            
        }

        public function index(): void           
        {
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
    }

?>