<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Interfaces\OrderRepositoryInterface;

final class OrderModel {

    /** @var OrderRepositoryInterface */
    private $orderStore;

    public function __construct(OrderRepositoryInterface $orders) {
        $this->orderStore = $orders;
    }

    public function createOrder($data) {
        return $this->orderStore->createOrder($data);
    }
    
    public function confirmOrderMailSent($orderId) {
        return $this->orderStore->confirmOrderMailSent($orderId);
    }

}
