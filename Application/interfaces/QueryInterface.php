<?php

declare(strict_types=1);

namespace Application\interfaces;

interface QueryInterface {
    public function selectFieldsFromTableOrderByField(string $table, array $fields, string $orderByField);
}