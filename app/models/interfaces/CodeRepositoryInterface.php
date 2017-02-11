<?php

//###INSERT-LICENSE-HERE###

namespace Models\Interfaces;

interface CodeRepositoryInterface {
    
    public function getCode($code);
    
    public function reserveCode($orderId, $code);

}