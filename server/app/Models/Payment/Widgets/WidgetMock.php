<?php

namespace App\Models\Payment\Widgets;

use App\Contracts\PaymentWidgetInterface;
use App\Models\Cart;

class WidgetMock implements PaymentWidgetInterface
{
	public function createPayment(Cart $cart, $type = null)
	{
		return [
			'id' => time(),
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
		$exec_delay = 30;

		return $payment_id + $exec_delay > time() ?
			[
				'status' => self::SUCCESS_STATUS,
				'paid' => 'true',			
			]
			: 
			[
				'status' => self::PENDING_STATUS,
				'paid' => 'false',
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