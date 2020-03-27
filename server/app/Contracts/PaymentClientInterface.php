<?php

namespace App\Contracts;

use App\Models\Cart;

interface PaymentClientInterface	 
{
	public function createPayment(Cart $cart, $type = null);
	public function getPaymentInfo($payment_id);
}