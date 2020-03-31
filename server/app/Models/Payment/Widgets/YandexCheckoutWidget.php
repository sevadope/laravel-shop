<?php

namespace App\Models\Payment\Widgets;

use App\Contracts\PaymentWidgetInterface;
use App\Models\Order;
use YandexCheckout\Client;
use App\Models\Cart;

class YandexCheckoutWidget implements PaymentWidgetInterface
{
	private $widget;

	public function createPayment(Cart $cart, $type = null)
	{
		$widget = $this->getWidget();

		$json_resp = $widget->createPayment(
			[
				'amount' => [
					'value' => $cart->getTotalPrice(),
					'currency' => 'RUB',
				],

				'confirmation' => [
					'type' => 'embedded',
				],

				'capture' => true,
				'description' => '',
			],
			uniqid('', true)
		);

		$resp = json_decode($json_resp, true);

		return [
			'confirmation_token' => $resp['confirmation']['confirmation_token'],
			'payment_id' => $resp['id'],
		];
	}

	public function getPaymentInfo($payment_id)
	{
		$widget = $this->getWidget();

		$json_resp = $widget->getPaymentInfo($payment_id);

		return json_decode($json_resp, true);
	}

	public function paymentSucceeded($payment_id)
	{
		$resp = $this->getPaymentInfo($payment_id);

		return $resp['status'] === self::SUCCESS_STATUS;
	}

	public function usesRedirectForSubmit()
	{
		return true;
	}

	private function getWidget()
	{
		if (isset($this->widget)) {
			return $this->widget;
		}	

		$widget = new Client;

		$widget->setAuth(
			config('payments.yandex_kassa.shop_id'),
			config('payments.yandex_kassa.secret_key')
		);		

		return $this->widget = $widget;
	}
}