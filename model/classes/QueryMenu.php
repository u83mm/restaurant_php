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
                    WHERE dishes_day.category_name = :field";

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
                    menu_id = :menu_id
                    WHERE dishe_id = :id";                 

            $stm = $dbcon->pdo->prepare($query);           
            foreach ($fields as $key => $value) {
                $stm->bindValue(":$key", $value); 
            }

            $stm->execute();       				
            $stm->closeCursor();
            $dbcon = null;            
        }
    }
    
?>