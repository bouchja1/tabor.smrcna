<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Repositories\MySql\BaseRepository;

final class MailsModel extends BaseRepository {

    const TABLE_NAME = "mails";

    public function findAllMails() {
        return $this->findAll(self::TABLE_NAME);
    }

    public function saveMail($values) {
        $this->insert($values);
    }
}
