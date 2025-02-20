<?php

declare(strict_types=1);

namespace Application\interfaces;

interface QueryInterface {
    public function selectFieldsFromTableOrderByField(string $table, array $fields, string $orderByField);
    public function selectOneBy(string $table, string $field, string $value): array|bool|object;
    public function selectAll(string $table): array;
    public function selectCount(string $table): mixed;
    public function updateRegistry(string $table, array $fields, string $primary_key_name);
    public function updatePassword(string $table, string $password, string $id_user);
    public function deleteRegistry(string $table, string $fieldId, string|int $id);
    public function selectOneByFieldNameInnerjoinOnfield(string $table1, string $table2, string $foreignKeyField, string $fieldName, string $field): array|bool;
    public function selectAllInnerjoinByField(string $table1, string $table2, string $foreignKeyField): array;
    public function insertInto(string $table, array|object $fields);
    public function truncateTable(string $table);
    public function selectFieldsFromTableById(array $fields, string $table, string $fieldId, string $value): array;
    public function selectAllAsJson(string $table, object $dbcon): string;
    public function updateRow(string $table, array|object $fields, string|int $id);
    public function selectAllOrderByFieldWhereFieldIsNotNull(string $table, string $field): array;
    public function selectAllOrderByField(string $table, string $field): array;
}