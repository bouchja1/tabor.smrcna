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
