<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Interfaces\CodeRepositoryInterface;

final class CodeModel {

    /** @var CodeRepositoryInterface */
    private $codeStore;

    public function __construct(CodeRepositoryInterface $codes) {
        $this->codeStore = $codes;
    }

    public function getCode($code) {
        return $this->codeStore->getCode($code);
    }

    public function reserveCode($orderId, $code) {
        return $this->codeStore->reserveCode($orderId, $code);
    }

}
