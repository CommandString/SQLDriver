<?php

namespace CommandString\Driver;

use PDOException;

class Query
{
    protected array $params = [];
    public bool $executed = false;

    public function __construct(
        public readonly string $query,
        public readonly Driver $driver
    ) {
    }

    /**
     * @throws DriverException
     */
    protected function throwIfNotExecuted(): void
    {
        if (!$this->executed) {
            throw new DriverException('Query already executed');
        }
    }

    /**
     * @throws DriverException
     */
    public function execute(?string $class = null): Rows
    {
        $stmt = $this->driver->pdo->prepare($this->query);

        try {
            $stmt->execute($this->params);
        } catch (PDOException $e) {
            throw new DriverException($e->getMessage(), $e->getCode(), $e);
        }

        return $class === null ? new Rows($stmt) : new MappedRows($stmt, $class);
    }

    public function bind(string $param, mixed $value): self
    {
        $this->params[$param] = $value;

        return $this;
    }
}
