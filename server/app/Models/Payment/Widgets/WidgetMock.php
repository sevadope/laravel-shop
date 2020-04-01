<?php

namespace App\Models\Payment\Widgets;

use App\Contracts\PaymentWidgetInterface;
use App\Models\Cart;

class WidgetMock implements PaymentWidgetInterface
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
				'id' => $payment_id,
				'status' => self::SUCCESS_STATUS,
				'paid' => 'true',			
		];
	}

	public function paymentSucceeded($payment_id)
	{
		$exec_delay = 30;

		return $exec_delay + $payment_id < time();
	}

	public function usesRedirectForSubmit()
	{
		return false;
	}
}