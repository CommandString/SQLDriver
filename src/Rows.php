<?php

namespace CommandString\Driver;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use PDO;
use PDOStatement;
use Traversable;

class Rows implements Countable, IteratorAggregate
{
    /** @var Row[] */
    protected array $rows;

    public function __construct(
        protected readonly PDOStatement $stmt
    ) {
        $this->rows = array_map(
            Row::create(...),
            $this->stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    public function count(): int
    {
        return $this->stmt->rowCount();
    }

    public function filter(callable $callback): static
    {
        $rows = [];

        foreach ($this->rows as $row) {
            if ($callback($row)) {
                $rows[] = $row;
            }
        }

        $that = clone $this;

        $that->rows = $rows;

        return $that;
    }

    public function find(callable $callback): ?Row
    {
        foreach ($this->rows as $row) {
            if ($callback($row)) {
                return $row;
            }
        }

        return null;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->rows);
    }
}
