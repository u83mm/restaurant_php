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

            $properties = [
                'aperitif'     => 'Aperitif',
                'aperitifQty'  => 'AperitifQty',
                'first'        => 'First',
                'firstQty'     => 'FirstQty',
                'second'       => 'Second',
                'secondQty'    => 'SecondQty',
                'dessert'      => 'Dessert',
                'dessertQty'   => 'DessertQty',
                'drink'        => 'Drink',
                'drinkQty'     => 'DrinkQty',
                'coffee'       => 'Coffee',
                'coffeeQty'    => 'CoffeeQty',
            ];
            
            foreach ($properties as $property => $string) {
                $value = implode(",", $order->{'get'.$string}());
                $value = ltrim($value, ",");
                $order->{'set'.$string}(explode(",", $value));
            }
                      

            try {
                $bindings = [                    
                    'aperitifs'     => $order->getAperitif(),
                    'aperitifs_qty' => $order->getAperitifQty(),
                    'firsts'        => $order->getFirst(),
                    'firsts_qty'    => $order->getFirstQty(),
                    'seconds'       => $order->getSecond(),
                    'seconds_qty'   => $order->getSecondQty(),
                    'desserts'      => $order->getDessert(),
                    'desserts_qty'  => $order->getDessertQty(),
                    'drinks'        => $order->getDrink(),
                    'drinks_qty'    => $order->getDrinkQty(),
                    'coffees'       => $order->getCoffee(),
                    'coffees_qty'   => $order->getCoffeeQty(),
                ];
                
                $stm = $dbcon->pdo->prepare($query);
                $stm->bindValue(":id", $order->getId());

                foreach ($bindings as $placeholder => $value) {
                    $value = implode(',', $value);
                    $stm->bindValue(':' . $placeholder, $value);
                }

                $stm->execute();       				
                $stm->closeCursor();

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1); 
            }
        }
    }
