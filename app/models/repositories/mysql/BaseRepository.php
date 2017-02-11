<?php

//###INSERT-LICENSE-HERE###

namespace Models\Repositories\MySql;

abstract class BaseRepository extends \Nette\Object {

    /** @var \DibiConnection */
    protected $connection;

    public function __construct(\DibiConnection $connection) {
        $this->connection = $connection;
    }

    protected function limitQuery($query, $limit) {
        if (isset($limit)) {
            $query->limit($limit);
        }
        return $query;
    }

    protected function offsetQuery($query, $offset) {
        if (isset($offset)) {
            $query->offset($offset);
        }
        return $query;
    }

}
