<?php

//###INSERT-LICENSE-HERE###

namespace Models\Interfaces;

interface OrderRepositoryInterface {

    public function createOrder($data);

    public function confirmOrderMailSent($orderId);
}
