<?php
namespace App\Services;

interface StripeServicesInterface{
    public function payestripe($tx);
}