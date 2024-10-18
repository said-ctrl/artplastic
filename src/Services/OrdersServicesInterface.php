<?php

namespace App\Services;

interface OrdersServicesInterface {
    public function makeOrder($total, $panier);
}