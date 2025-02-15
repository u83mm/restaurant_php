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
        ORDER BY dishes.dishe_id
        LIMIT :desde, :pagerows";
    
        $stm = $this->dbcon->pdo->prepare($query);
        $stm->bindValue(":desde", $desde); 
        $stm->bindValue(":pagerows", $pagerows);                                        
        $stm->execute();       
        $rows = $stm->fetchAll();
        $stm->closeCursor();

        return $rows;
    }

    public function selectOneBy(string $table, string $field, string $value): Dishe 
    {
        $query = "SELECT * FROM $table WHERE $field = :val";                         

        try {
            $stm = $this->dbcon->pdo->prepare($query);
            $stm->bindValue(":val", $value);                            
            $stm->execute();       
            $rows = $stm->fetch(\PDO::FETCH_ASSOC);
            $stm->closeCursor();

            return new Dishe($rows);

        } catch (\Throwable $th) {
            throw new \Exception("{$th->getMessage()}", 1);
        }
    }   
}
