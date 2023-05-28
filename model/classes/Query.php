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

            try {
                $stm = $dbcon->pdo->prepare($query);               
                $stm->execute();       
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
                $stm->closeCursor();                

                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }
        }

        /**
         * Select count from "table name"
         */
        public function selectCount(string $table, object $dbcon): mixed     
        {
            $query = "SELECT COUNT(*) FROM $table";                 

            try {
                $stm = $dbcon->pdo->prepare($query);               
                $stm->execute();       
                $rows = $stm->fetchColumn();
                $stm->closeCursor();
                $dbcon = null;

                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }
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

            try {
                $stm = $dbcon->pdo->prepare($query);
                $stm->bindValue(":val", $value);                            
                $stm->execute();       
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
                $stm->closeCursor();

                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }
        }

        public function selectOneBy(string $table, string $field, string $value, object $dbcon): array|bool 
        {
            $query = "SELECT * FROM $table WHERE $field = :val";                         

            try {
                $stm = $dbcon->pdo->prepare($query);
                $stm->bindValue(":val", $value);                            
                $stm->execute();       
                $rows = $stm->fetch(PDO::FETCH_ASSOC);
                $stm->closeCursor();

                return $rows ?? false;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }
        }

        /**
         * The function updates a record in a database table using the provided fields and primary key
         * name.
         * 
         * @param string table The name of the database table to update.
         * @param array fields An associative array containing the fields to be updated in the table,
         * where the keys are the column names and the values are the new values to be set.
         * @param string primary_key_name The name of the primary key column in the table being
         * updated.
         * @param object dbcon  is an object representing the database connection. It is used to
         * prepare and execute the SQL query.
         */
        public function updateRegistry(string $table, array $fields, string $primary_key_name, object $dbcon): void
        {
            $query = "UPDATE $table SET";
            $params = [];
            
            foreach ($fields as $key => $value) {
               if($key !== $primary_key_name)  $query .= " $key = :$key,";
               $params[":$key"] = $value;
            }
            
            $query = rtrim($query, ",");
            $query .= " WHERE $primary_key_name = :$primary_key_name";
            $params[":$primary_key_name"] = $fields[$primary_key_name];                        
                                                  
            try {
                $stm = $dbcon->pdo->prepare($query);                        
                $stm->execute($params);       				
                $stm->closeCursor();
                $dbcon = null;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }            
        }


        public function updatePassword(string $table, string $password, string $id_user, object $dbcon): void
        {
            $query = "UPDATE $table SET password = :password WHERE id = :id_user";                 
                        
            try {
                $stm = $dbcon->pdo->prepare($query); 
                $stm->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));				            
                $stm->bindValue(":id_user", $id_user);              
                $stm->execute();       				
                $stm->closeCursor();
                $dbcon = null;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }
        }


        public function deleteRegistry(string $table, string $fieldId, string $id, object $dbcon)
        {
            $query = "DELETE FROM $table WHERE $fieldId = :id";                 

            try {
                $stm = $dbcon->pdo->prepare($query);             			            
                $stm->bindValue(":id", $id);              
                $stm->execute();       				
                $stm->closeCursor();
                $dbcon = null;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1); 
            }            
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
                    
            try {
                $stm = $dbcon->pdo->prepare($query);
                $stm->bindValue(":id", $id);                            
                $stm->execute();       
                $rows = $stm->fetch(PDO::FETCH_ASSOC);            
                $stm->closeCursor();

                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);                
            }
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
                        ON $table1.$foreignKeyField = $table2.$foreignKeyField
                        ORDER BY $table1.id";
                
            try {
                $stm = $dbcon->pdo->prepare($query);                                                   
                $stm->execute();       
                $rows = $stm->fetchAll();
                $stm->closeCursor();
            
                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}");
            }
        }


        /**
         * > This function inserts a record into a table
         * 
         * @param array fields an array of fields to be inserted into the database.
         * @param string table The table name
         * @param object dbcon The database connection object.
         */
        public function insertInto(string $table, array|object $fields, object $dbcon): void
        {
            /** Initialice variables */
            $query = $values = "";
            $insert = "INSERT INTO $table (";            

            foreach ($fields as $key => $value) {
                $insert .= $key . ",";
                $values .= ":$key,";
            }

            /** Prepare variables for make the query */
            $insert_size = strlen($insert);
            $insert = substr($insert, 0, $insert_size-1) . ") VALUES (";          
            $value_size = strlen($values);
            $values = substr($values, 0, $value_size-1) . ")";

            /** Make the query */
            $query = $insert . $values;            
                                                    
            try {
                $stm = $dbcon->pdo->prepare($query);
                foreach ($fields as $key => $value) {
                    if($key === 'password') {
                        $stm->bindValue(":password", password_hash($value, PASSWORD_DEFAULT));
                        continue;
                    }
                    
                    $stm->bindValue(":$key", $value);
                }                   
                $stm->execute();       				
                $stm->closeCursor();
                
            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);             
            }
        }


       /**
        * > This function truncates a table
        * 
        * @param string table The name of the table you want to truncate.
        * @param dbcon This is the database connection object.
        */
        public function truncateTable(string $table, $dbcon): void
        {
            $query = "TRUNCATE TABLE $table";
                
            try {
                $stm = $dbcon->pdo->prepare($query);                                                   
                $stm->execute();                   
                $stm->closeCursor();

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}");
            }
        }


        /**
         * This function selects specific fields from a given table using PDO and returns the resulting
         * rows as an array.
         * 
         * @param string table The name of the database table from which to select fields.
         * @param array fields An array of strings representing the names of the fields to be selected
         * from the table.
         * @param object dbcon  is an object representing the database connection. It is likely
         * an instance of a class that manages database connections and provides a PDO object for
         * executing queries.
         * 
         * @return array an array of rows fetched from the specified table, containing only the
         * specified fields.
         */
        public function selectFieldsFromTableOrderByField(string $table, array $fields, string $orderByField, object $dbcon): array
        {
            $fields = implode(", ", $fields);
            $query = "SELECT $fields FROM $table ORDER BY $orderByField";

            try {
                $stm = $dbcon->pdo->prepare($query);                                                   
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