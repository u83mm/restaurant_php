<?php
    namespace Application\model\classes;

    use PDO;

    class Query 
    {
        public Language $languageObject;
        
        public function __construct(protected object $dbcon = DB_CON, public array $language = [])      
        {
            $this->languageObject = new Language();
        }

        /**
         * Select all from "table name"
         */
        public function selectAll(string $table): array     
        {
            $query = "SELECT * FROM $table";                 

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

        /**
         * Select count from "table name"
         */
        public function selectCount(string $table): mixed     
        {
            $query = "SELECT COUNT(*) FROM $table";                 

            try {
                $stm = $this->dbcon->pdo->prepare($query);               
                $stm->execute();       
                $rows = $stm->fetchColumn();
                $stm->closeCursor();                

                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }
        }

     
        /**
         * The function selects all rows from a specified table and optionally orders the results.
         * 
         * @param string table The name of the table 
         * @param string field The name of the column in the database table
         * that you want to filter the results by.
         * @param string value The `` parameter is the value that you want to match in the
         * specified field of the table. It can be either a string or a float.
         * @param object dbcon The `` parameter is an object that represents the database
         * connection. It is expected to have a property named `pdo` which is an instance of the PDO
         * class. The PDO class is a PHP extension that provides a lightweight and consistent interface
         * for interacting with databases.
         * @param string orderBy The `` parameter is an optional parameter that specifies the
         * column by which the result should be ordered. If a value is provided for ``, the
         * result will be sorted in ascending order based on the specified column. If no value is
         * provided, the result will be returned in the order in which
         * 
         * @return array an array of rows fetched from the database table that match the specified
         * field and value.
         */
        public function selectAllBy(string $table, string $field, string|float $value, string $orderBy = null): array  
        {
            $query = "SELECT * FROM $table WHERE $field = :val";
            
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

        public function selectOneBy(string $table, string $field, string $value): array|bool|object
        {
            $query = "SELECT * FROM $table WHERE $field = :val";                         

            try {
                $stm = $this->dbcon->pdo->prepare($query);
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
        public function updateRegistry(string $table, array $fields, string $primary_key_name): void
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
                $stm = $this->dbcon->pdo->prepare($query);                        
                $stm->execute($params);       				
                $stm->closeCursor();               

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }            
        }
      
        /**
         * This PHP function updates a user's password in a specified table using a hashed password and
         * the user's ID.
         * 
         * @param string table The `table` parameter 
         * @param string password The `password` parameter
         * @param string id_user The `id_user` parameter
         * @param object dbcon The `dbcon` parameter
         */
        public function updatePassword(string $table, string $password, string $id_user): void
        {
            $query = "UPDATE $table SET password = :password WHERE id = :id_user";                 
                        
            try {
                $stm = $this->dbcon->pdo->prepare($query); 
                $stm->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));				            
                $stm->bindValue(":id_user", $id_user);              
                $stm->execute();       				
                $stm->closeCursor();                

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }
        }

        /** Delete a row */
        public function deleteRegistry(string $table, string $fieldId, string|int $id)
        {
            $query = "DELETE FROM $table WHERE $fieldId = :id";                 

            try {
                $stm = $this->dbcon->pdo->prepare($query);             			            
                $stm->bindValue(":id", $id);              
                $stm->execute();       				
                $stm->closeCursor();               

            } catch (\Throwable $th) {
                $this->dbcon->pdo->rollBack();
                throw new \Exception("{$th->getMessage()}", 1); 
            }            
        }


        /**
         * Select one registry by their "fieldName" doing JOIN with another table by their foreign key
         */
        public function selectOneByFieldNameInnerjoinOnfield(string $table1, string $table2, string $foreignKeyField, string $fieldName, string $field) :array|bool
        {
            $query = "SELECT * FROM $table1 
                        INNER JOIN $table2                        
                        USING ($foreignKeyField)
                        WHERE $table1.$fieldName = :field";
                    
            try {
                $stm = $this->dbcon->pdo->prepare($query);
                $stm->bindValue(":field", $field);                            
                $stm->execute();       
                $rows = $stm->fetch(PDO::FETCH_ASSOC);            
                $stm->closeCursor();

                return $rows ?? false;

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
        public function selectAllInnerjoinByField(string $table1, string $table2, string $foreignKeyField): array
        {
            $query = "SELECT * FROM $table1 
                        INNER JOIN $table2 
                        ON $table1.$foreignKeyField = $table2.$foreignKeyField
                        ORDER BY $table1.id";
                
            try {
                $stm = $this->dbcon->pdo->prepare($query);                                                   
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
        public function insertInto(string $table, array|object $fields): void
        {
            /** Initialice variables */
            $query = $values = "";
            $insert = "INSERT INTO $table (";            

            if(is_object($fields) && method_exists($fields, 'getFields')) $fields = $fields->getFields();

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
                $stm = $this->dbcon->pdo->prepare($query);
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
                $this->dbcon->pdo->rollBack();
                throw new \Exception("{$th->getMessage()}", 1);             
            }
        }


       /**
        * > This function truncates a table
        * 
        * @param string table The name of the table you want to truncate.
        * @param dbcon This is the database connection object.
        */
        public function truncateTable(string $table): void
        {
            $query = "TRUNCATE TABLE $table";
                
            try {
                $stm = $this->dbcon->pdo->prepare($query);                                                   
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
         * @param object dbcon  is an object representing the database connection. 
         * 
         * @return array an array of rows fetched from the specified table, containing only the
         * specified fields.
         */
        public function selectFieldsFromTableOrderByField(string $table, array $fields, string $orderByField): array
        {
            $fields = implode(", ", $fields);
            $query = "SELECT $fields FROM $table ORDER BY $orderByField ASC";

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

        
       /**
        * The function `selectFieldsFromTableById` retrieves specific fields from a table based on a
        * given ID value.
        * 
        * @param array fields An array of field names that you want to select from the table.
        * @param string table The `table` parameter 
        * @param string id The id field in the table (ex. user_id).
        * @param string value The id value.
        * 
        * @return array An array containing the selected fields from the specified table where the
        * provided ID matches the given value.
        */
        public function selectFieldsFromTableById(array $fields, string $table, string $fieldId, string $value): array
        {
            $fields = implode(", ", $fields);
            $query = "SELECT $fields FROM $table WHERE $fieldId = :value";

            try {
                $stm = $this->dbcon->pdo->prepare($query);
                $stm->bindValue(":value", $value);                                                   
                $stm->execute();       
                $rows = $stm->fetch(PDO::FETCH_ASSOC);
                $stm->closeCursor();
            
                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}");
            }
        }

        /**
         * Select all from "table name" and return as JSON
         */
        public function selectAllAsJson(string $table, object $dbcon): string
        {
            $query = "SELECT * FROM $table";

            try {
                $stm = $dbcon->pdo->prepare($query);
                $stm->execute();
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
                $stm->closeCursor();

                return json_encode($rows);

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }
        }

        public function updateRow(string $table, array|object $fields, string|int $id): void
        {
            /** Initialice variables */
            $query = "";
            $count = 0;
            $query = "UPDATE $table SET ";            

            foreach ($fields as $key => $value) {
                if(++$count === count($fields)) {
                    $query .= $key . " = :" . $key;
                } else {
                    $query .= $key . " = :" . $key . ", ";
                }                
            }
            
            $query .= " WHERE id = '$id'";            
                                                    
            try {
                $stm = $this->dbcon->pdo->prepare($query);
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
         * Select all from "table name"
         */
        public function selectAllOrderByFieldWhereFieldIsNotNull(string $table, string $field): array     
        {
            $query = "SELECT * FROM $table WHERE $field IS NOT NULL ORDER BY $field ASC";                 

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

        public function selectAllOrderByField(string $table, string $field): array     
        {
            $query = "SELECT * FROM $table ORDER BY $field ASC";                 

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
    }    
?>