<?php

declare(strict_types=1);

namespace Application\model\repositories\dishe;

use Application\model\classes\DishCategory;
use Application\model\classes\Query;

final class CategoryRepository extends Query
{
    public function __construct(
        protected object $dbcon = DB_CON,        
    ) 
    {
        
    }    
    
    public function saveCategory(object $entity): void
    {
        $this->insertInto('dishes_menu', [
            'menu_category' => $entity->getCategory(),
            'menu_emoji'    => $entity->getEmoji()
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
                'category' => $rows['menu_category'],
                'emoji'    => $rows['menu_emoji']
            ]);

        } catch (\Throwable $th) {
            throw new \Exception("{$th->getMessage()}", 1);
        }
    }
}
