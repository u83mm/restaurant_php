<?php
    namespace Application\model\classes;

    use PDO;

    class QueryMenu extends Query
    {                
        public function __construct(protected object $dbcon = DB_CON)
        {
            $this->languageObject = new Language();
        }

        public function selectDishesOfDay(string $field):array
        {           
            $query = "SELECT * FROM dishes 
                    INNER JOIN dishes_day USING(category_id)
                    INNER JOIN dishes_menu USING(menu_id)
                    INNER JOIN dinamic_data USING (dishe_id) 
                    WHERE dishes_day.category_name = :field
                    AND dishes.available";

            try {
                $stm = $this->dbcon->pdo->prepare($query);
                $stm->bindValue(":field", $field);                            
                $stm->execute();       
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
                $stm->closeCursor();

                /** Set name and description to render */
                foreach ($rows as $key_row => $row) {
                    foreach ($row as $key => $value) {
                        if($key === "{$_SESSION['language']}_name") {
                            $rows[$key_row]['name'] = $value;
                        }

                        if($key == "$_SESSION[language]_description") {
                            $rows[$key_row]['description'] = $value;
                        }
                    }                    
                }

                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }            
        } 
        
        public function updateDishe(array $fields): void
        {                               
            $query = "UPDATE dishes SET name = :name, description = :description, category_id = :category_id, 
                    menu_id = :menu_id, picture = :picture, price = :price, available = :available
                    WHERE dishe_id = :id";                 

            try {
                $stm = $this->dbcon->pdo->prepare($query);
                      
                foreach ($fields as $key => $value) {
                    if(is_int($value)) {
                        $stm->bindValue(":$key", $value, PDO::PARAM_INT);
                        continue;       
                    }

                    $stm->bindValue(":$key", strtolower($value));                
                }
                
                $stm->execute();       				
                $stm->closeCursor();

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }                        
        }

        public function selectAllInnerjoinByMenuCategory(string $table1, string $table2, string $foreignKeyField, string $menuCategory): array
        {
            $query = "SELECT * FROM $table1 
                        INNER JOIN $table2 USING($foreignKeyField)
                        INNER JOIN dinamic_data USING(dishe_id)
                        WHERE $table2.$_SESSION[language]_menu_category = :menu_category";

            try {
                $stm = $this->dbcon->pdo->prepare($query);
                $stm->bindValue(":menu_category", $menuCategory);                                         
                $stm->execute();       
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
                $stm->closeCursor();
                
                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }            
        }

        public function showMenuListByCategory(array $menuCategories, string $category)
        {
            try {
                /** Configure page language */           
                $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();
                
                $showResult = "";             

                for($i = 0, $y = 3; $i < count($menuCategories); $i++) {                
                    $menuCategory = ucfirst($menuCategories[$i]['name']);
                    
                    if($menuCategories[$i]['available']) {
                        $showResult .= "<li class='showMenuCategories'><a class='btn btn-outline-secondary' href='/menu/showDisheInfo/{$menuCategories[$i]['dishe_id']}'>{$menuCategory}</a></li>";
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

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }            
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
        public function getMenuDayPrice(): float
        {            
            $rows = $this->selectAll("menu_day_price");            
            
            return $rows[0]['price'] ?? 0.00;
        }

        public function selectDishesLikePagination(int $desde, int $pagerows, string $field, string|int $value)
        {           
            $query = "SELECT * FROM dishes
                    INNER JOIN dishes_day USING(category_id)                    
                    INNER JOIN dishes_menu USING(menu_id)
                    INNER JOIN dinamic_data USING(dishe_id)";                  

                    $query .= $field === "available" ? " WHERE dishes.$field = :value" : " WHERE dinamic_data.{$_SESSION['language']}_{$field} LIKE :value";

                    $query .= " ORDER BY dishes.dishe_id
                                LIMIT :desde, :pagerows";
            
            try {
                $stm = $this->dbcon->pdo->prepare($query);
                $stm->bindValue(":desde", $desde); 
                $stm->bindValue(":pagerows", $pagerows);
    
                $value = is_int($value) ? $value : "%{$value}%";
                
                $stm->bindValue(":value", $value);                                         
                $stm->execute();       
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
                $stm->closeCursor();
                
                /** Set name and description to render */
                foreach ($rows as $key_row => $row) {
                    foreach ($row as $key => $value) {
                        if($key === "{$_SESSION['language']}_name") {
                            $rows[$key_row]['name'] = $value;
                        }

                        if($key == "$_SESSION[language]_description") {
                            $rows[$key_row]['description'] = $value;
                        }
                    }                    
                }
    
                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }            
        }


        public function selectDishesByPagination(int $desde, int $pagerows, string $field, string $value)
        {           
            $query = "SELECT * FROM dishes
                    INNER JOIN dishes_day USING(category_id)                    
                    INNER JOIN dishes_menu USING(menu_id)
                    INNER JOIN dinamic_data USING(dishe_id) 
                    WHERE dishes.$field = :value
                    ORDER BY dishes.dishe_id
                    LIMIT :desde, :pagerows";

            try {
                $stm = $this->dbcon->pdo->prepare($query);
                $stm->bindValue(":desde", $desde); 
                $stm->bindValue(":pagerows", $pagerows);            
                $stm->bindValue(":value", $value);                                         
                $stm->execute();       
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
                $stm->closeCursor();
                
                /** Set name and description to render */
                foreach ($rows as $key_row => $row) {
                    foreach ($row as $key => $value) {
                        if($key === "{$_SESSION['language']}_name") {
                            $rows[$key_row]['name'] = $value;
                        }

                        if($key == "$_SESSION[language]_description") {
                            $rows[$key_row]['description'] = $value;
                        }
                    }                    
                }
    
                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }            
        }

       
        public function selectDishesLikeCritery(string $field, string|int $value)
        {           
            $query = "SELECT * FROM dishes
                    INNER JOIN dishes_day USING(category_id)                    
                    INNER JOIN dishes_menu USING(menu_id)
                    INNER JOIN dinamic_data USING(dishe_id)";                                    

                    $query .= is_int($value) ? " WHERE dishes.$field = :value" : " WHERE dinamic_data.{$_SESSION['language']}_{$field} LIKE :value";
                   
                    $query .= " ORDER BY dishes.dishe_id";          
            try {
                $stm = $this->dbcon->pdo->prepare($query); 
            
                $value = $field === "available" ? $value : "%$value%";
                
                $stm->bindValue(":value", $value);                                                  
                $stm->execute();       
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);         
                $stm->closeCursor();
                
                /** Set name and description to render */
                foreach ($rows as $key_row => $row) {
                    foreach ($row as $key => $value) {
                        if($key === "{$_SESSION['language']}_name") {
                            $rows[$key_row]['name'] = $value;
                        }

                        if($key == "$_SESSION[language]_description") {
                            $rows[$key_row]['description'] = $value;
                        }
                    }                    
                }
    
                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }            
        }


        public function selectDishesByCritery(string $field, string|int $value)
        {           
            $query = "SELECT * FROM dishes
                    INNER JOIN dishes_day USING(category_id)                    
                    INNER JOIN dishes_menu USING(menu_id)                    
                    WHERE dishes.$field = :value
                    ORDER BY dishes.dishe_id";           
            try {
                $stm = $this->dbcon->pdo->prepare($query);                        
                $stm->bindValue(":value", $value);                                                  
                $stm->execute();       
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);         
                $stm->closeCursor();                                                                           
    
                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }            
        }

        /** Return an array with the elements to show in the Day's menu aside section */
        public function getMenuDayElements() : array {
            try {
                $menuDayInfo = [
                    'main'    =>  $this->selectDishesOfDay('primero'),
                    'second'  =>  $this->selectDishesOfDay('segundo'),
                    'dessert' =>  $this->selectDishesOfDay('postre'),
                    'price'   =>  $this->getMenuDayPrice(),
                ];
    
                return $menuDayInfo;
                
            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }            
        }
    }
    
?>