<?php
    namespace model\classes;

    use PDO;

    class QueryMenu extends Query
    {
        public function selectDishesOfDay(string $field, object $dbcon):array
        {
            $query = "SELECT * FROM dishes 
                    INNER JOIN dishes_day
                    ON dishes.category_id = dishes_day.category_id 
                    WHERE dishes_day.category_name = :field
                    AND dishes.available = 1";

            $stm = $dbcon->pdo->prepare($query);
            $stm->bindValue(":field", $field);                            
            $stm->execute();       
            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
            $stm->closeCursor();

            return $rows;
        } 
        
        public function updateDishe(array $fields, object $dbcon): void
        {                               
            $query = "UPDATE dishes SET name = :name, description = :description, category_id = :category_id, 
                    menu_id = :menu_id, picture = :picture, price = :price, available = :available
                    WHERE dishe_id = :id";                 

            $stm = $dbcon->pdo->prepare($query);
                      
            foreach ($fields as $key => $value) {
                if(is_numeric($value)) {
                    $stm->bindValue(":$key", $value);
                    continue;       
                }

                $stm->bindValue(":$key", strtolower($value));                
            }

            $stm->execute();       				
            $stm->closeCursor();
            $dbcon = null;            
        }

        public function selectAllInnerjoinByMenuCategory(string $table1, string $table2, string $foreignKeyField, string $menuCategory, object $dbcon): array
        {
            $query = "SELECT * FROM $table1 
                        INNER JOIN $table2 
                        ON $table1.$foreignKeyField = $table2.$foreignKeyField
                        WHERE $table2.menu_category = :menu_category";
                
            $stm = $dbcon->pdo->prepare($query);
            $stm->bindValue(":menu_category", $menuCategory);                                         
            $stm->execute();       
            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
            $stm->closeCursor();
            
            return $rows;
        }

        public function showMenuListByCategory(array $menuCategories, string $category)
        { 
            /** Configure page language */           
			$this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();
            
            $showResult = ""; 

            for($i = 0, $y = 3; $i < count($menuCategories); $i++) {                
                $menuCategory = ucfirst($this->language["{$menuCategories[$i]['name']}"]);
                
                if($menuCategories[$i]['available'] === 1) {
                    $showResult .= "<li class='showMenuCategories'><a class='btn btn-outline-secondary' href='/menu/info_dishe/show_info.php?id={$menuCategories[$i]['dishe_id']}'>{$menuCategory}</a></li>";
                }

                if($i == $y || $i == count($menuCategories)-1) {
                    $showResult .= "</ul></div>";
                    if($y < count($menuCategories)) {
                        $showResult .= '<div class="col-12 col-sm-6 col-md-4 col-lg-3"><ul class="ps-0">';
                    }

                    $y += 4; 
                }               
            }

            return $showResult;
        }

        /**
         * It returns the price of the menu of the day, which is the sum of the prices of the dishes of
         * the first, second and dessert courses multiplied by 1.5
         * 
         * @param array primeros array of dishes of the first course
         * @param array segundos array of dishes
         * @param array postres array of dishes
         * 
         * @return float The price of the menu of the day.
         */
        public function getMenuDayPrice(object $dbcon): float
        {            
            $rows = parent::selectAll("menu_day_price", $dbcon);

            $menuDayPrice = $rows[0]['price'] ?? 0.00;
            
            return $menuDayPrice;
        }

        public function selectDishesLikePagination(string $desde, string $pagerows, string $field, string $value, object $dbcon)
        {           
            $query = "SELECT * FROM dishes
                    INNER JOIN dishes_day 
                    ON dishes.category_id = dishes_day.category_id
                    INNER JOIN dishes_menu
                    ON dishes.menu_id = dishes_menu.menu_id
                    WHERE dishes.$field LIKE :value
                    ORDER BY dishes.dishe_id
                    LIMIT :desde, :pagerows";

            $stm = $dbcon->pdo->prepare($query);
            $stm->bindValue(":desde", $desde); 
            $stm->bindValue(":pagerows", $pagerows);
            $value = "%{$value}%";
            $stm->bindValue(":value", $value);                                         
            $stm->execute();       
            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
            $stm->closeCursor();                                                                           

            return $rows;
        }


        public function selectDishesByPagination(string $desde, string $pagerows, string $field, string $value, object $dbcon)
        {           
            $query = "SELECT * FROM dishes
                    INNER JOIN dishes_day 
                    ON dishes.category_id = dishes_day.category_id
                    INNER JOIN dishes_menu
                    ON dishes.menu_id = dishes_menu.menu_id
                    WHERE dishes.$field = :value
                    ORDER BY dishes.dishe_id
                    LIMIT :desde, :pagerows";

            $stm = $dbcon->pdo->prepare($query);
            $stm->bindValue(":desde", $desde); 
            $stm->bindValue(":pagerows", $pagerows);            
            $stm->bindValue(":value", $value);                                         
            $stm->execute();       
            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
            $stm->closeCursor();                                                                           

            return $rows;
        }


        public function selectDishesLikeCritery(string $field, string $value, object $dbcon)
        {           
            $query = "SELECT * FROM dishes
                    INNER JOIN dishes_day 
                    ON dishes.category_id = dishes_day.category_id
                    INNER JOIN dishes_menu
                    ON dishes.menu_id = dishes_menu.menu_id
                    WHERE dishes.$field LIKE :value
                    ORDER BY dishes.dishe_id";           

            $stm = $dbcon->pdo->prepare($query);            
            $value = "%{$value}%";
            $stm->bindValue(":value", $value);                                                  
            $stm->execute();       
            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);         
            $stm->closeCursor();                                                                           

            return $rows;
        }


        public function selectDishesByCritery(string $field, string $value, object $dbcon)
        {           
            $query = "SELECT * FROM dishes
                    INNER JOIN dishes_day 
                    ON dishes.category_id = dishes_day.category_id
                    INNER JOIN dishes_menu
                    ON dishes.menu_id = dishes_menu.menu_id
                    WHERE dishes.$field = :value
                    ORDER BY dishes.dishe_id";           

            $stm = $dbcon->pdo->prepare($query);                        
            $stm->bindValue(":value", $value);                                                  
            $stm->execute();       
            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);         
            $stm->closeCursor();                                                                           

            return $rows;
        }
    }
    
?>