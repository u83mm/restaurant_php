<?php

declare(strict_types=1);

namespace Application\model\repositories\dishe;
use Application\model\classes\DishCategory;
use Application\model\classes\Query;

final class CategoryRepository extends Query
{
    public function __construct(                
    ) 
    {
        parent::__construct();
    }    
    
    public function saveCategory(object $entity): void
    {
        $this->insertInto('dishes_menu', [
            "{$_SESSION['language']}_menu_category" => $entity->getCategory(),
            'menu_emoji'                            => $entity->getEmoji()
        ]);
    }

    public function selectOneBy(string $table, string $field, string $value): DishCategory 
    {
        $query = "SELECT * FROM $table WHERE $field = :val";                         

        try {
            $stm = $this->dbcon->pdo->prepare($query);
            $stm->bindValue(":val", $value);                            
            $stm->execute();       
            $rows = $stm->fetch(\PDO::FETCH_ASSOC);
            $stm->closeCursor();

            return new DishCategory([
                'id'       => $rows['menu_id'],
                'category' => $rows["{$_SESSION['language']}_menu_category"] == null ? "" : $rows["{$_SESSION['language']}_menu_category"],
                'emoji'    => $rows['menu_emoji']
            ]);

        } catch (\Throwable $th) {
            throw new \Exception("{$th->getMessage()}", 1);
        }
    }

    public function updateRegistry(string $table, array $fields, string $primary_key_name): bool
    {
        $query = "UPDATE $table SET";
        $params = [];
        
        foreach ($fields as $key => $value) {
            if($key !== $primary_key_name)  $query .= " $key = :$key,";
            $params[":$key"] = strtolower($value);
        }
        
        $query = rtrim($query, ",");
        $query .= " WHERE $primary_key_name = :$primary_key_name";
        $params[":$primary_key_name"] = $fields[$primary_key_name];                        
                                                
        try {
            $stm = $this->dbcon->pdo->prepare($query);                        
            $stm->execute($params);       				
            $stm->closeCursor();

            if($stm->rowCount() > 0) return true;

            return false;

        } catch (\Throwable $th) {
            throw new \Exception("{$th->getMessage()}", 1);
        }            
    }

    public function insertInto(string $table, array|object $fields): bool
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
            $query = strtolower($insert) . strtolower($values);            
                                                    
            try {
                $stm = $this->dbcon->pdo->prepare($query);
                foreach ($fields as $key => $value) {                    
                    $stm->bindValue(":$key", strtolower($value));
                }                   
                $stm->execute();       				
                $stm->closeCursor();

                return true; // Return true if the insert was successful
                
            } catch (\Throwable $th) {
                $this->dbcon->pdo->rollBack();
                throw new \Exception("{$th->getMessage()}", 1);             
            }
        }
}
