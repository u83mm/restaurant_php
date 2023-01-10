<?php
    namespace model\classes;

    use PDO;

    class Query 
    {
        /**
         * Select all from "table name"
         */
        public function selectAll(string $table, object $dbcon): array     
        {
            $query = "SELECT * FROM $table";                 

            $stm = $dbcon->pdo->prepare($query);               
            $stm->execute();       
            $rows = $stm->fetchAll();
            $stm->closeCursor();
            //$dbcon = null;

            return $rows;
        }

      /**
       * > This function takes in a table name, a field name, a value, and a database connection
       * object, and returns an array of all the rows in the table that match the field and value
       * 
       * @param string table The table name
       * @param string field The field you want to search for.
       * @param string value The value to be searched for.
       * @param object dbcon The database connection object.
       * 
       * @return array An array of associative arrays.
       */
        public function selectAllBy(string $table, string $field, string $value, object $dbcon): array  
        {
            $query = "SELECT * FROM $table WHERE $field = :val";                         

            $stm = $dbcon->pdo->prepare($query);
            $stm->bindValue(":val", $value);                            
            $stm->execute();       
            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
            $stm->closeCursor();

            return $rows;
        }

        public function selectOneBy(string $table, string $field, string $value, object $dbcon): array  
        {
            $query = "SELECT * FROM $table WHERE $field = :val";                         

            $stm = $dbcon->pdo->prepare($query);
            $stm->bindValue(":val", $value);                            
            $stm->execute();       
            $rows = $stm->fetch(PDO::FETCH_ASSOC);
            $stm->closeCursor();

            return $rows;
        }

        public function updateRegistry(string $table, string $user_name, string $email, string $id_user, object $dbcon): void
        {
            $query = "UPDATE $table SET user_name = :user_name, email = :email WHERE id_user = :id_user";                 

            $stm = $dbcon->pdo->prepare($query); 
            $stm->bindValue(":user_name", $user_name);				
            $stm->bindValue(":email", $email);
            $stm->bindValue(":id_user", $id_user);              
            $stm->execute();       				
            $stm->closeCursor();
            $dbcon = null;            
        }

        public function updatePassword(string $table, string $password, string $id_user, object $dbcon): void
        {
            $query = "UPDATE $table SET password = :password WHERE id_user = :id_user";                 

            $stm = $dbcon->pdo->prepare($query); 
            $stm->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));				            
            $stm->bindValue(":id_user", $id_user);              
            $stm->execute();       				
            $stm->closeCursor();
            $dbcon = null;            
        }

        public function deleteRegistry(string $table, string $fieldId, string $id, object $dbcon)
        {
            $query = "DELETE FROM $table WHERE $fieldId = :id";                 

            $stm = $dbcon->pdo->prepare($query);             			            
            $stm->bindValue(":id", $id);              
            $stm->execute();       				
            $stm->closeCursor();
            $dbcon = null;            
        }

        /**
         * Select one registry by their "id" doing JOIN with another table by their foreign key
         */
        public function selectOneByIdInnerjoinOnfield(string $table1, string $table2, string $foreignKeyField, string $fieldId, string $id, object $dbcon):array
        {
            $query = "SELECT * FROM $table1 
                        INNER JOIN $table2
                        ON $table1.$foreignKeyField = $table2.$foreignKeyField
                        WHERE $table1.$fieldId = :id";
                    
            $stm = $dbcon->pdo->prepare($query);
            $stm->bindValue(":id", $id);                            
            $stm->execute();       
            $rows = $stm->fetch(PDO::FETCH_ASSOC);            
            $stm->closeCursor();

            return $rows;
        }        

        /**
         * > This function selects all the records from two tables and returns the result as an array
         * 
         * @param string table1 The first table you want to join
         * @param string table2 The table you want to join to.
         * @param string foreignKeyField The field in the first table that is the foreign key to the
         * second table.
         * @param object dbcon The database connection object.
         * 
         * @return array An array of objects.
         */
        public function selectAllInnerjoinByField(string $table1, string $table2, string $foreignKeyField, object $dbcon): array
        {
            $query = "SELECT * FROM $table1 
                        INNER JOIN $table2 
                        ON $table1.$foreignKeyField = $table2.$foreignKeyField";
                
            $stm = $dbcon->pdo->prepare($query);                                                   
            $stm->execute();       
            $rows = $stm->fetchAll();
            $stm->closeCursor();
            
            return $rows;
        }
    }    
?>