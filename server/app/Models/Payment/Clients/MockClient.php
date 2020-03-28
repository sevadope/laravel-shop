<?php

namespace App\Models\Payment\Clients;

use App\Contracts\PaymentClientInterface;
use App\Models\Cart;

class MockClient implements PaymentClientInterface
{
	public function createPayment(Cart $cart, $type = null)
	{
		return [
			'id' => \Str::random(20),
			'status' => self::PENDING_STATUS,
			'paid' => 'false',

			'amount' => [
				'value' => $cart->getTotalPrice(),
				'currency' => 'RUB',
			],
		];
	}

	public function getPaymentInfo($payment_id)
	{
		return [
			'status' => self::SUCCESS_STATUS,
			'paid' => 'true',			
		];
	}

	public function paymentSucceeded($payment_id)
	{
		return true;
	}
}