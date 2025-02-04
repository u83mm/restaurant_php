<?php
    declare(strict_types=1);
    
    namespace model\classes;

use Application\interfaces\QueryInterface;
use model\classes\Query;
    use PDO;

    /* The QueryReservations class is a PHP class that extends the Query class and provides a method to
    select all records from a table based on a given date and time. */
    class QueryReservations extends Query implements QueryInterface
    {    
        public function selectAllByDateAndTime(
            string $table, 
            string $field, 
            string $value,             
            string $time = null, 
            string $orderBy = null, 
            ) : array 
        {
            $query = "SELECT * FROM $table WHERE $field = :val";
            
            if($time) $query .= " AND time = $time ";
            if ($orderBy) $query .= " ORDER BY $orderBy";             

            try {
                $stm = $this->dbcon->pdo->prepare($query);
                $stm->bindValue(":val", $value);                            
                $stm->execute();       
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
                $stm->closeCursor();

                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            } 
        }
        
        /** Select distinct dates from current date */
        public function selectDistinctDatesFromCurrent(string $table) : array {
            $query = "SELECT DISTINCT date FROM $table WHERE date >= CURRENT_DATE() ORDER BY date ASC";                                       

            try {
                $stm = $this->dbcon->pdo->prepare($query);                                            
                $stm->execute();       
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
                $stm->closeCursor();                

                return $rows;
                        
            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }  
        }

        public function selectFieldsFromTableOrderByField(string $table, array $fields, string $orderByField): array
        {
            $fields = implode(", ", $fields);
            $query = "SELECT $fields FROM $table 
                    WHERE date >= CURRENT_DATE() 
                    ORDER BY $orderByField DESC";

            try {
                $stm = $this->dbcon->pdo->prepare($query);                                                   
                $stm->execute();       
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
                $stm->closeCursor();
            
                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}");
            }
        }
    }    
?>