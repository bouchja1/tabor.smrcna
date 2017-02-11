<?php

//###INSERT-LICENSE-HERE###

namespace Models\Repositories\MySql;

use Models\Interfaces\OrderRepositoryInterface;

final class OrderRepository extends BaseRepository implements OrderRepositoryInterface {

    const TABLE_NAME = "orders";

    public function createOrder($data) {
        $this->connection
                ->insert(self::TABLE_NAME, $data)
                ->execute();

        return $this->connection->getInsertId();
    }

    public function confirmOrderMailSent($orderId) {
        $this->connection
                ->update(self::TABLE_NAME, array('sent' => true))
                ->where('[id] = %i', $orderId)
                ->execute();
    }

}
