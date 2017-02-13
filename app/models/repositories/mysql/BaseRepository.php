<?php

//###INSERT-LICENSE-HERE###

namespace Models\Repositories\MySql;

abstract class BaseRepository extends \Nette\Object
{

    /** @var \DibiConnection */
    protected $connection;

    public function __construct(\DibiConnection $connection)
    {
        $this->connection = $connection;
    }

    public function insert($values)
    {
        try {
            $this->getDatabase()->query("INSERT INTO [" . static::TABLE_NAME . "]", (array)$values);
        } catch (\DibiDriverException $ex) {
            throw $ex;
        }
    }

    /**
     * Similart to $dibi->begin($savepoint) with support for ignore $savepoint name when is not $isNestedTransaction
     *
     * @param string $savepoint Savepoint name for nested transactions
     * @param bool $isNestedTransaction When transaction is nested or not => when $savepoint should be ignored or not
     */
    public function begin($savepoint = null, $isNestedTransaction = false) {
        if ($isNestedTransaction) {
            $this->getDatabase()->begin($savepoint);
        } else {
            $this->getDatabase()->begin();
        }
    }

    /**
     * Delete row $id or ignore
     *
     * @param type $id
     * @return type
     */
    public function delete($id) {
        return $this->getDatabase()->query("DELETE FROM [" . static::TABLE_NAME . "] WHERE [id] = %i", $id);
    }

    /**
     * Similart to $dibi->rollback($savepoint) with support for ignore $savepoint name when is not $isNestedTransaction
     *
     * @param string $savepoint Savepoint name for nested transactions
     * @param bool $isNestedTransaction When transaction is nested or not => when $savepoint should be ignored or not
     */
    public function rollback($savepoint = null, $isNestedTransaction = false) {
        if ($isNestedTransaction) {
            $this->getDatabase()->rollback($savepoint);
        } else {
            $this->getDatabase()->rollback();
        }
    }

    /**
     * Similart to $dibi->commit($savepoint) with support for ignore $savepoint name when is not $isNestedTransaction
     *
     * @param string $savepoint Savepoint name for nested transactions
     * @param bool $isNestedTransaction When transaction is nested or not => when $savepoint should be ignored or not
     */
    public function commit($savepoint = null, $isNestedTransaction = false) {
        if ($isNestedTransaction) {
            $this->getDatabase()->commit($savepoint);
        } else {
            $this->getDatabase()->commit();
        }
    }

    public function update($values)
    {
        $valuesArray = (array)$values;
        $id = $valuesArray["id"];
        unset($valuesArray["id"]);

        try {
            return $this->getDatabase()->query("UPDATE [" . static::TABLE_NAME . "] SET ", (array)$valuesArray, " WHERE [id] = %i", $id);
        } catch (\DibiDriverException $ex) {
            throw $ex;
        }
    }

    protected function limitQuery($query, $limit)
    {
        if (isset($limit)) {
            $query->limit($limit);
        }
        return $query;
    }

    protected function offsetQuery($query, $offset)
    {
        if (isset($offset)) {
            $query->offset($offset);
        }
        return $query;
    }

    protected function findAll($tableName)
    {
        return $this->connection
            ->select("*")
            ->from($tableName)
            ->orderBy('id', 'DESC')
            ->fetchAll();
    }

    protected function findById($id)
    {
        return $this->connection
            ->select("*")
            ->from(static::TABLE_NAME)
            ->where("[id] = %i", $id)
            ->fetch();
    }

    /**
     * @return \DibiConnection
     */
    final public function getDatabase()
    {
        return $this->connection;
    }

}
