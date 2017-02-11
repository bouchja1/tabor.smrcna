<?php

//###INSERT-LICENSE-HERE###

namespace Models\Repositories\MySql;

use Models\Interfaces\CodeRepositoryInterface;

final class CodeRepository extends BaseRepository implements CodeRepositoryInterface {

    const TABLE_NAME = "codes";

    public function getCode($code) {
        return $this->connection
                        ->select("count(*)")
                        ->as("count")
                        ->select("[code]")
                        ->select("[is_employee]")
                        ->from(self::TABLE_NAME)
                        ->where("[code] = %s", $code)
                        ->and("[order_id] IS NULL")
                        ->fetch();
    }

    public function reserveCode($orderId, $code) {
        return $this->connection
                        ->update(self::TABLE_NAME, array("order_id" => $orderId))
                        ->where("[code] = %s", $code)
                        ->execute();
    }

}
