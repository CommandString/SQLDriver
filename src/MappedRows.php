<?php

namespace CommandString\Driver;

use PDOStatement;
use Tnapf\JsonMapper\Mapper;
use Tnapf\JsonMapper\MapperInterface;

class MappedRows extends Rows
{
    /** @var object[] */
    protected array $rows;

    public function __construct(
        PDOStatement $stmt,
        string $class,
        ?MapperInterface $mapper = null
    ) {
        parent::__construct($stmt);

        $mapper ??= new Mapper();

        $rows = [];

        foreach ($this->rows as $row) {
            $row = $row->getColumns();

            foreach ($row as &$column) {
                if ($decoded = json_decode($column, true)) {
                    $column = $decoded;
                }
            }

            $rows[] = $row;
        }

        $this->rows = array_map(
            static fn ($row) => $mapper->map($class, $row),
            $rows
        );
    }
}
