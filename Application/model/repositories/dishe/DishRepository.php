<?php

declare(strict_types=1);

namespace Application\model\repositories\dishe;

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
    
    public function saveCategory(object $entity): void
    {
        $this->insertInto('dishes_menu', [
            'menu_category' => $entity->getCategory(),
            'menu_emoji'    => $entity->getEmoji()
        ]);
    }
}
