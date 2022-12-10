<?php

namespace App\Shared\Infra\Drivers;

use App\Shared\Adapters\Contracts\QueryBuilder\QueryStatement;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\Shared\Adapters\Contracts\DatabaseDriver;

class DoctrineDriver implements DatabaseDriver
{
    protected $conn;
    protected $config;
    private static $isDevMode = true;

    public function __construct(array $connectionsParams)
    {
        $this->config = new Configuration();
        $config = Setup::createAnnotationMetadataConfiguration(array('/var/www/html/src/Shared/Domain/Entity'), self::$isDevMode, null, null, false);
        $this->conn = EntityManager::create(
            DriverManager::getConnection($connectionsParams, $this->config),
            $config
        );
    }

    public function close()
    {
        $this->conn = null;
    }

    public function setQueryStatement(QueryStatement $queryStatement): DatabaseDriver
    {
        $this->queryStatement = $queryStatement;
        return $this;
    }

    public function execute(): DatabaseDriver
    {
        $this->statement = $this->conn->getConnection()->prepare((string)$this->queryStatement);
        $this->statement->execute($this->queryStatement->getValues());
        return $this;
    }

    public function executeSql(string $sql, array $values = []): DatabaseDriver
    {
        $this->statement = $this->conn->getConnection()->prepare($sql);
        $this->statement->execute($values);
        return $this;
    }

    public function lastInsertedId(): int
    {
        return  $this->conn->getConnection()->lastInsertId();
    }

    public function fetchOne(): ?array
    {
        $record = $this->statement->fetch();

        if ($record === false) {
            return null;
        }

        return $record;
    }

    public function fetchAll(): array
    {
        return $this->statement->fetchAll();
    }

    public function beginTransaction(): bool
    {
        return $this->conn->getConnection()->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->conn->getConnection()->commit();
    }

    public function rollback(): bool
    {
        return $this->conn->getConnection()->rollback();
    }

    public function batchInsert(array $columns, array $values): bool
    {
        $columnCount = count($columns);
        $columnList = '(' . implode(', ', $columns) . ')';
        $rowPlaceholder = ' (' . implode(', ', array_fill(1, $columnCount, '?')) . ')';
        $this->rawQuery = sprintf(
            'INSERT INTO %s%s VALUES %s',
            $this->table,
            $columnList,
            implode(', ', array_fill(1, count($values), $rowPlaceholder))
        );

        $this->query = $this->conn->getConnection()->prepare($this->rawQuery);

        $data = [];

        foreach ($values as $rowData) {
            $data = array_merge($data, array_values($rowData));
        }

        return $this->query->execute($data);
    }

    public function find(string $name, int $id)
    {
        return $this->conn->find($name, $id);
    }

    public function persist(object $entity)
    {
        $this->conn->persist($entity); 
        return $this->conn->flush();
    }
}
