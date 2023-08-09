<?php

namespace CommandString\Driver;

class Row
{
    public static function create(array $row): static
    {
        return new static($row);
    }

    public function __construct(
        protected readonly array $row
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->getColumns();
    }

    public function getColumns(): array
    {
        return $this->row;
    }

    public function getColumn(string $columnName): mixed
    {
        return $this->row[$columnName] ?? null;
    }

    public function getColumnNames(): array
    {
        return array_keys($this->row);
    }
}
