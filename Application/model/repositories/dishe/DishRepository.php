<?php

declare(strict_types=1);

namespace Application\model\repositories\dishe;

use Application\model\classes\Dishe;
use Application\model\classes\Query;

final class DishRepository extends Query
{
    public function __construct(
        protected object $dbcon = DB_CON,        
    ) 
    {        
    }

    public function selectAllDishes(int $desde, int $pagerows): array
    {
        /** Select all dishes from DB */
        $query = "SELECT * FROM dishes 
        INNER JOIN dishes_day USING(category_id)
        INNER JOIN dishes_menu USING(menu_id) 
        INNER JOIN dinamic_data USING (dishe_id)            
        ORDER BY dishes.dishe_id
        LIMIT :desde, :pagerows";
    
        $stm = $this->dbcon->pdo->prepare($query);
        $stm->bindValue(":desde", $desde); 
        $stm->bindValue(":pagerows", $pagerows);                                   
        $stm->execute();       
        $rows = $stm->fetchAll();
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
    }

    public function selectDisheById(string $id): array 
    {
        $query = "SELECT * FROM dishes 
                INNER JOIN dishes_day USING(category_id)
                INNER JOIN dishes_menu USING(menu_id)
                INNER JOIN dinamic_data USING (dishe_id)                
                WHERE dishes.dishe_id = :id";                 

        try {
            $stm = $this->dbcon->pdo->prepare($query);
            $stm->bindValue(":id", $id);                            
            $stm->execute();       
            $rows = $stm->fetch(\PDO::FETCH_ASSOC);
            $stm->closeCursor();

            /** Set name and description to render */
            foreach ($rows as $key => $value) {
                if($key === "{$_SESSION['language']}_name") {
                    $rows['name'] = $value;
                }

                if($key == "$_SESSION[language]_description") {
                    $rows['description'] = $value;
                }
            }

            return $rows;

        } catch (\Throwable $th) {
            throw new \Exception("{$th->getMessage()}", 1);
        }
    }

    public function selectDishesByCategory(string $category): array 
    {
        $query = "SELECT * FROM dishes 
                INNER JOIN dishes_day USING(category_id)
                INNER JOIN dishes_menu USING(menu_id)
                INNER JOIN dinamic_data USING (dishe_id)
                WHERE dishes_menu.{$_SESSION['language']}_menu_category = :category";                    

        try {
            $stm = $this->dbcon->pdo->prepare($query);
            $stm->bindValue(":category", $category);                            
            $stm->execute();       
            $rows = $stm->fetchAll(\PDO::FETCH_ASSOC);
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
        $this->dbcon->pdo->beginTransaction();

        $query = "UPDATE dishes 
                SET category_id = :category_id, 
                menu_id = :menu_id,
                picture = :picture,
                price = :price, 
                available = :available 
                WHERE dishe_id = :dishe_id";
        
        try {
            $stm = $this->dbcon->pdo->prepare($query);
            $stm->bindValue(":category_id", $fields['category_id']);
            $stm->bindValue(":menu_id", $fields['menu_id']);
            $stm->bindValue(":picture", $fields['picture']);
            $stm->bindValue(":price", $fields['price']);
            $stm->bindValue(":available", $fields['available'], \PDO::PARAM_BOOL);
            $stm->bindValue(":dishe_id", $fields['dishe_id']);
            $stm->execute();           
            $stm->closeCursor();

        } catch (\Throwable $th) {
            $this->dbcon->pdo->rollBack();
            throw new \Exception("{$th->getMessage()}", 1);
        }

        $query = "UPDATE dinamic_data
                SET $_SESSION[language]_name = :name, 
                $_SESSION[language]_description = :description 
                WHERE dishe_id = :dishe_id";
        
        try {
            $stm = $this->dbcon->pdo->prepare($query);
            $stm->bindValue(":name", $fields['name']);
            $stm->bindValue(":description", $fields['description']);
            $stm->bindValue(":dishe_id", $fields['dishe_id']);
            $stm->execute();           
            $stm->closeCursor();

        } catch (\Throwable $th) {
            $this->dbcon->pdo->rollBack();
            throw new \Exception("{$th->getMessage()}", 1);
        }

        $this->dbcon->pdo->commit();
    }      
}
