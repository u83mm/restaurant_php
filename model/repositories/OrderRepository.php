<?php
    namespace model\repositories;

    use model\classes\Query;
    use model\orders\Order;

    class OrderRepository extends Query
    {
        public function saveOrder( Order $order, object $dbcon): void
        {
            $query = "INSERT INTO orders (
                        table_number, 
                        people_qty, 
                        aperitifs,
                        aperitifs_qty,
                        firsts,
                        firsts_qty,
                        seconds,
                        seconds_qty,
                        desserts,
                        desserts_qty,
                        drinks,
                        drinks_qty,
                        coffees,
                        coffees_qty
                    )
                    VALUES(
                        :table_number, 
                        :people_qty, 
                        :aperitifs,
                        :aperitifs_qty,
                        :firsts,
                        :firsts_qty,
                        :seconds,
                        :seconds_qty,
                        :desserts,
                        :desserts_qty,
                        :drinks,
                        :drinks_qty,
                        :coffees,
                        :coffees_qty
                    )";                        

            try {
                $stm = $dbcon->pdo->prepare($query);
                $stm->bindValue(":table_number",  $order->getTable());
                $stm->bindValue(":people_qty",    $order->getPeople());
                $stm->bindValue(":aperitifs",     implode(',', $order->getAperitif()));
                $stm->bindValue(":aperitifs_qty", implode(',', $order->getAperitifQty()));
                $stm->bindValue(":firsts",        implode(',', $order->getFirst()));
                $stm->bindValue(":firsts_qty",    implode(',', $order->getFirstQty()));
                $stm->bindValue(":seconds",       implode(',', $order->getSecond()));
                $stm->bindValue(":seconds_qty",   implode(',', $order->getSecondQty()));
                $stm->bindValue(":desserts",      implode(',', $order->getDessert()));
                $stm->bindValue(":desserts_qty",  implode(',', $order->getDessertQty()));
                $stm->bindValue(":drinks",        implode(',', $order->getDrink()));
                $stm->bindValue(":drinks_qty",    implode(',', $order->getDrinkQty()));
                $stm->bindValue(":coffees",       implode(',', $order->getCoffee()));
                $stm->bindValue(":coffees_qty",   implode(',', $order->getCoffeeQty())); 

                $stm->execute();       				
                $stm->closeCursor();                
                
            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);             
            }
        }

        public function updateOrder(Order $order, object $dbcon): void
        {
            $query = "UPDATE orders SET 
                        aperitifs     = :aperitifs, 
                        aperitifs_qty = :aperitifs_qty,
                        firsts        = :firsts,
                        firsts_qty    = :firsts_qty,
                        seconds       = :seconds,
                        seconds_qty   = :seconds_qty,
                        desserts      = :desserts,
                        desserts_qty  = :desserts_qty,
                        drinks        = :drinks,
                        drinks_qty    = :drinks_qty,
                        coffees       = :coffees,
                        coffees_qty   = :coffees_qty
                    WHERE id = :id
                    ";

            try {
                $stm = $dbcon->pdo->prepare($query);
                $stm->bindValue(":id",             $order->getId());
                $stm->bindValue(":aperitifs",     implode(',', $order->getAperitif()));
                $stm->bindValue(":aperitifs_qty", implode(',', $order->getAperitifQty()));
                $stm->bindValue(":firsts",        implode(',', $order->getFirst()));
                $stm->bindValue(":firsts_qty",    implode(',', $order->getFirstQty()));
                $stm->bindValue(":seconds",       implode(',', $order->getSecond()));
                $stm->bindValue(":seconds_qty",   implode(',', $order->getSecondQty()));
                $stm->bindValue(":desserts",      implode(',', $order->getDessert()));
                $stm->bindValue(":desserts_qty",  implode(',', $order->getDessertQty()));
                $stm->bindValue(":drinks",        implode(',', $order->getDrink()));
                $stm->bindValue(":drinks_qty",    implode(',', $order->getDrinkQty()));
                $stm->bindValue(":coffees",       implode(',', $order->getCoffee()));
                $stm->bindValue(":coffees_qty",   implode(',', $order->getCoffeeQty())); 

                $stm->execute();       				
                $stm->closeCursor();                
            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1); 
            }
        }
    }
