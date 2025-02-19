<?php

declare(strict_types=1);

namespace Application\interfaces;

interface QueryInterface {
    public function selectFieldsFromTableOrderByField(string $table, array $fields, string $orderByField);
    public function selectOneBy(string $table, string $field, string $value): array|bool|object;
    public function selectAll(string $table): array;
    public function selectCount(string $table): mixed;
    public function updateRegistry(string $table, array $fields, string $primary_key_name);
}