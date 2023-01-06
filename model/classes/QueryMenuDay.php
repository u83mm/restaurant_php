<?php
    namespace model\classes;

    use PDO;

    class QueryMenuDay extends Query
    {
        public function __construct(private object $dbcon)
        {

        } 

        public function selectAllDishesByCategory(string $field):array
        {
            $query = "SELECT * FROM dishes 
                    INNER JOIN dishes_category 
                    ON dishes.category_id = dishes_category.category_id 
                    WHERE dishes_category.category_name = :field";

            $stm = $this->dbcon->pdo->prepare($query);
            $stm->bindValue(":field", $field);                            
            $stm->execute();       
            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
            $stm->closeCursor();

            return $rows;
        } 
        
        public function updateDishe(string $name, string $description, string $categoryId, string $id): void
        {
            $query = "UPDATE dishes SET name = :name, description = :description, category_id = :category_id WHERE dishe_id = :id";                 

            $stm = $this->dbcon->pdo->prepare($query); 
            $stm->bindValue(":name", $name); 
            $stm->bindValue(":description", $description); 
            $stm->bindValue(":category_id", $categoryId);          
            $stm->bindValue(":id", $id);              
            $stm->execute();       				
            $stm->closeCursor();
            $dbcon = null;            
        }
    }
    
?>