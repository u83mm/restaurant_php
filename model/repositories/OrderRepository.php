<?php
    namespace model\repositories;

    use model\classes\Query;
    use model\orders\Order;

    class OrderRepository extends Query
    {
        /**
         * The function saves an order to a database using prepared statements in PHP.
         * 
         * @param Order order An instance of the Order class, containing information about the order to
         * be saved in the database.
         * @param object dbcon  is an object representing the database connection. It is used to
         * prepare and execute the SQL query to insert the order data into the database.
         */
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


        /**
         * This function updates an order in a database with the provided order object and database
         * connection.
         * 
         * @param Order order An instance of the Order class representing the order to be updated.
         * @param object dbcon The  parameter is an object that represents a database connection.
         * It is used to prepare and execute the SQL query to update an order in the database.
         */
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

            // CONFIGURAR OPCIÓN DE LIMPIAR LAS COMAS INICIALES EN EL PRIMER ELEMENTO DE CADA PROPIEDAD

            $aperitif_string     = implode(",", $order->getAperitif());
            $aperitif_qty_string = implode(",", $order->getAperitifQty());
            $first_string        = implode(",", $order->getFirst());
            $first_qty_string    = implode(",", $order->getFirstQty());
            $second_string       = implode(",", $order->getSecond());
            $second_qty_string   = implode(",", $order->getSecondQty());
            $dessert_string      = implode(",", $order->getDessert());
            $dessert_qty_string  = implode(",", $order->getDessertQty());
            $drink_string        = implode(",", $order->getDrink());
            $drink_qty_string    = implode(",", $order->getDrinkQty());
            $coffee_string       = implode(",", $order->getCoffee());
            $coffee_qty_string   = implode(",", $order->getCoffeeQty());

            if (preg_match('/^,/', $aperitif_string))     $aperitif_string     = ltrim($aperitif_string, ",");
            if (preg_match('/^,/', $aperitif_qty_string)) $aperitif_qty_string = ltrim($aperitif_qty_string, ",");
            if (preg_match('/^,/', $first_string))        $first_string        = ltrim($first_string, ",");
            if (preg_match('/^,/', $first_qty_string))    $first_qty_string    = ltrim($first_qty_string, ",");
            if (preg_match('/^,/', $second_string))       $second_string       = ltrim($second_string, ",");
            if (preg_match('/^,/', $second_qty_string))   $second_qty_string   = ltrim($second_qty_string, ",");
            if (preg_match('/^,/', $dessert_string))      $dessert_string      = ltrim($dessert_string, ",");
            if (preg_match('/^,/', $dessert_qty_string))  $dessert_qty_string  = ltrim($dessert_qty_string, ",");
            if (preg_match('/^,/', $drink_string))        $drink_string        = ltrim($drink_string, ",");
            if (preg_match('/^,/', $drink_qty_string))    $drink_qty_string    = ltrim($drink_qty_string, ",");
            if (preg_match('/^,/', $coffee_string))       $coffee_string       = ltrim($coffee_string, ",");
            if (preg_match('/^,/', $coffee_qty_string))   $coffee_qty_string   = ltrim($coffee_qty_string, ",");

            $order->setAperitif(explode(",", $aperitif_string));
            $order->setAperitifQty(explode(",", $aperitif_qty_string));
            $order->setFirst(explode(",", $first_string));
            $order->setFirstQty(explode(",", $first_qty_string));
            $order->setSecond(explode(",", $second_string));
            $order->setSecondQty(explode(",", $second_qty_string));
            $order->setDessert(explode(",", $dessert_string));
            $order->setDessertQty(explode(",", $dessert_qty_string));
            $order->setDrink(explode(",", $drink_string));
            $order->setDrinkQty(explode(",", $drink_qty_string));
            $order->setCoffee(explode(",", $coffee_string));
            $order->setCoffeeQty(explode(",", $coffee_qty_string));            

            try {
                $stm = $dbcon->pdo->prepare($query);
                $stm->bindValue(":id", $order->getId());
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
