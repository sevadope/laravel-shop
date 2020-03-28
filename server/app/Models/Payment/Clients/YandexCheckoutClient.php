<?php

namespace App\Models\Payment\Clients;

use App\Contracts\PaymentClientInterface;
use App\Models\Order;
use YandexCheckout\Client;
use App\Models\Cart;

class YandexCheckoutClient implements PaymentClientInterface
{
	private $client;

	public function createPayment(Cart $cart, $type = null)
	{
		$client = $this->getClient();

		$json_resp = $client->createPayment(
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
		$client = $this->getClient();

		$json_resp = $client->getPaymentInfo($payment_id);

		return json_decode($json_resp, true);
	}

	public function paymentSucceeded($payment_id)
	{
		$resp = $this->getPaymentInfo($payment_id);

		return $resp['status'] === self::SUCCESS_STATUS;
	}

	private function getClient()
	{
		if (isset($this->client)) {
			return $this->client;
		}	

		$client = new Client;

		$client->setAuth(
			config('payments.yandex_kassa.shop_id'),
			config('payments.yandex_kassa.secret_key')
		);		

		return $this->client = $client;
	}
}