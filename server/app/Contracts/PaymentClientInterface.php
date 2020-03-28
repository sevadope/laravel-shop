<?php

namespace App\Contracts;

use App\Models\Cart;

interface PaymentClientInterface	 
{
	public const PENDING_STATUS = 'pending';
	public const SUCCESS_STATUS = 'succeeded';

	public function createPayment(Cart $cart, $type = null);
	public function getPaymentInfo($payment_id);
	public function paymentSucceeded($payment_id);
}