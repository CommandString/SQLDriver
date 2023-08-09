<?php

namespace CommandString\Driver;

use PDO;

class Driver
{
    public readonly PDO $pdo;

    public function __construct(
        protected Dsn $dsn,
        ?string $username = null,
        ?string $password = null,
        ?array $options = null
    ) {
        $this->pdo = new PDO(
            $this->dsn,
            $username,
            $password,
            $options
        );
    }

    public function createQuery(string $query): Query
    {
        return new Query($query, $this);
    }
}
