<?php
    namespace model\classes;

    use PDO;

    class QueryMenuDay extends Query
    {
        public function selectAllDishesByCategory(string $field, object $dbcon):array
        {
            $query = "SELECT * FROM dishes 
                    INNER JOIN dishes_category 
                    ON dishes.category_id = dishes_category.category_id 
                    WHERE dishes_category.category_name = :field";

            $stm = $dbcon->pdo->prepare($query);
            $stm->bindValue(":field", $field);                            
            $stm->execute();       
            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
            $stm->closeCursor();

            return $rows;
        }
    }
    
?>