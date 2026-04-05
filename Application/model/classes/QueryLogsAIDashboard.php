<?php

declare(strict_types=1);

namespace Application\model\classes;

use Application\interfaces\QueryInterface;

final class QueryLogsAIDashboard extends Query implements QueryInterface
{
    public function __construct(protected object $dbcon = DB_CON, public array $language = [])      
    {
        return parent::__construct($dbcon, $language);
    }

    public function deleteRegistries(string $table): void
    {
        $query = "DELETE FROM $table WHERE created_at < DATE_SUB(NOW(), INTERVAL 7 DAY)";

        try {
            $stm = $this->dbcon->pdo->prepare($query);
            $stm->execute();
            $stm->closeCursor();
        }
        catch (\Throwable $th) {
            throw new \Exception("{$th->getMessage()}", 1);
        }
    }
}