<?php
    namespace Application\model\repositories;

    use Application\model\classes\Query;
    use Application\model\orders\Order;

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
        public function saveOrder( Order $order): void
        {
            $query = "INSERT INTO orders (
                        table_number, 
                        people_qty,
                        aperitifs_id, 
                        aperitifs,
                        aperitifs_qty,
                        firsts_id,
                        firsts,
                        firsts_qty,
                        seconds_id,
                        seconds,
                        seconds_qty,
                        desserts_id,
                        desserts,
                        desserts_qty,
                        drinks_id,
                        drinks,
                        drinks_qty,
                        coffees_id,
                        coffees,
                        coffees_qty
                    )
                    VALUES(
                        :table_number, 
                        :people_qty,
                        :aperitifs_id, 
                        :aperitifs,
                        :aperitifs_qty,
                        :firsts_id,
                        :firsts,
                        :firsts_qty,
                        :seconds_id,
                        :seconds,
                        :seconds_qty,
                        :desserts_id,
                        :desserts,
                        :desserts_qty,
                        :drinks_id,
                        :drinks,
                        :drinks_qty,
                        :coffees_id,
                        :coffees,
                        :coffees_qty
                    )";                        

            try {
                $stm = $this->dbcon->pdo->prepare($query);
                $stm->bindValue(":table_number",  $order->getTable());
                $stm->bindValue(":people_qty",    $order->getPeople());
                $stm->bindValue(":aperitifs_id",  implode(',', $order->getAperitifId()));
                $stm->bindValue(":aperitifs",     implode(',', $order->getAperitif()));
                $stm->bindValue(":aperitifs_qty", implode(',', $order->getAperitifQty()));
                $stm->bindValue(":firsts_id",     implode(',', $order->getFirstId()));
                $stm->bindValue(":firsts",        implode(',', $order->getFirst()));
                $stm->bindValue(":firsts_qty",    implode(',', $order->getFirstQty()));
                $stm->bindValue(":seconds_id",    implode(',', $order->getSecondId()));
                $stm->bindValue(":seconds",       implode(',', $order->getSecond()));
                $stm->bindValue(":seconds_qty",   implode(',', $order->getSecondQty()));
                $stm->bindValue(":desserts_id",   implode(',', $order->getDessertId()));
                $stm->bindValue(":desserts",      implode(',', $order->getDessert()));
                $stm->bindValue(":desserts_qty",  implode(',', $order->getDessertQty()));
                $stm->bindValue(":drinks_id",     implode(',', $order->getDrinkId()));
                $stm->bindValue(":drinks",        implode(',', $order->getDrink()));
                $stm->bindValue(":drinks_qty",    implode(',', $order->getDrinkQty()));
                $stm->bindValue(":coffees_id",    implode(',', $order->getCoffeeId()));
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
        public function updateOrder(Order $order): void
        {
            $query = "UPDATE orders SET
                        aperitifs_id       = :aperitifs_id, 
                        aperitifs          = :aperitifs, 
                        aperitifs_qty      = :aperitifs_qty,
                        aperitifs_finished = :aperitifs_finished,
                        firsts_id          = :firsts_id,
                        firsts             = :firsts,
                        firsts_qty         = :firsts_qty,
                        firsts_finished    = :firsts_finished,
                        seconds_id         = :seconds_id,
                        seconds            = :seconds,
                        seconds_qty        = :seconds_qty,
                        seconds_finished   = :seconds_finished,
                        desserts_id        = :desserts_id,
                        desserts           = :desserts,
                        desserts_qty       = :desserts_qty,
                        desserts_finished  = :desserts_finished,
                        drinks_id         = :drinks_id,
                        drinks             = :drinks,
                        drinks_qty         = :drinks_qty,
                        drinks_finished    = :drinks_finished,
                        coffees_id         = :coffees_id,
                        coffees            = :coffees,
                        coffees_qty        = :coffees_qty,
                        coffees_finished   = :coffees_finished
                    WHERE id = :id
                    ";            

            $properties = [
                'aperitifId'       => 'AperitifId',
                'aperitif'         => 'Aperitif',
                'aperitifQty'      => 'AperitifQty',
                'aperitifFinished' => 'AperitifFinished',
                'firstId'          => 'FirstId',
                'first'            => 'First',
                'firstQty'         => 'FirstQty',
                'firstFinished'    => 'FirstFinished',
                'secondId'         => 'SecondId',
                'second'           => 'Second',
                'secondQty'        => 'SecondQty',
                'secondFinished'   => 'SecondFinished',
                'dessertId'        => 'DessertId',
                'dessert'          => 'Dessert',
                'dessertQty'       => 'DessertQty',
                'dessertFinished'  => 'DessertFinished',
                'drinkId'          => 'DrinkId',
                'drink'            => 'Drink',
                'drinkQty'         => 'DrinkQty',
                'drinkFinished'    => 'DrinkFinished',
                'coffeeId'         => 'CoffeeId',
                'coffee'           => 'Coffee',
                'coffeeQty'        => 'CoffeeQty',
                'coffeeFinished'   => 'CoffeeFinished',
            ];
            
            foreach ($properties as $property => $string) {
                $value = implode(",", $order->{'get'.$string}());
                $value = ltrim($value, ",");
                $order->{'set'.$string}(explode(",", $value));
            }
                      

            try {
                $bindings = [
                    'aperitifs_id'       => $order->getAperitifId(),                    
                    'aperitifs'          => $order->getAperitif(),
                    'aperitifs_qty'      => $order->getAperitifQty(),
                    'aperitifs_finished' => $order->getAperitifFinished(),
                    'firsts_id'          => $order->getFirstId(),
                    'firsts'             => $order->getFirst(),
                    'firsts_qty'         => $order->getFirstQty(),
                    'firsts_finished'    => $order->getFirstFinished(),
                    'seconds_id'         => $order->getSecondId(),
                    'seconds'            => $order->getSecond(),
                    'seconds_qty'        => $order->getSecondQty(),
                    'seconds_finished'   => $order->getSecondFinished(),
                    'desserts_id'        => $order->getDessertId(),
                    'desserts'           => $order->getDessert(),
                    'desserts_qty'       => $order->getDessertQty(),
                    'desserts_finished'  => $order->getDessertFinished(),
                    'drinks_id'          => $order->getDrinkId(),
                    'drinks'             => $order->getDrink(),
                    'drinks_qty'         => $order->getDrinkQty(),
                    'drinks_finished'    => $order->getDrinkFinished(),
                    'coffees_id'         => $order->getCoffeeId(),
                    'coffees'            => $order->getCoffee(),
                    'coffees_qty'        => $order->getCoffeeQty(),
                    'coffees_finished'   => $order->getCoffeeFinished(),
                ];
                
                $stm = $this->dbcon->pdo->prepare($query);
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
