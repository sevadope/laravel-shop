<?php

namespace App\Services;

use App\Models\Payment\Widgets\YandexCheckoutWidget;
use App\Models\Payment\Widgets\MockWidget;

class PaymentService
{
	private $payment_widgets = [
		'yandex_checkout' => YandexCheckoutWidget::class,
		'mock_widget' => MockWidget::class,
	];

	public function getWidget($widget_name)
	{
		if (array_key_exists($widget_name, $this->payment_widgets)) {
			return new $this->payment_widgets[$widget_name];
		}

		throw new \LogicException("Undefined payment widget: '$widget'", 1);
	}
}