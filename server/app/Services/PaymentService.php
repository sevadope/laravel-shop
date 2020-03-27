<?php

namespace App\Services;

use YandexCheckout\Client as YxClient;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment\Clients\YandexCheckoutClient;
use App\Models\Payment\Clients\MockClient;

class PaymentService
{
	private $payment_clients = [
		'yandex_checkout' => YandexCheckoutClient::class,
		'mock' => MockClient::class,
	];

	public function getClient($client)
	{
		if (array_key_exists($client, $this->payment_clients)) {
			return new $this->payment_clients[$client];
		}

		throw new \LogicException("Undefined payment client: '$client'", 1);
	}	
}