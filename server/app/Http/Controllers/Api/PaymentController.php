<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Payment\InitWidgetRequest;
use App\Http\Requests\Payment\StoreMockRequest;
use App\Models\Cart;
use App\Services\PaymentService;
use App\Models\Order;
use App\Jobs\CheckPaymentStatus;

class PaymentController extends Controller
{
    public function initWidget(
    	InitWidgetRequest $req,
        PaymentService $service,
        Cart $cart
    )
    {
        # Get payment client for chosen widget
    	$widget_name = $req->validated()['name'];
        $widget = $service->getWidget($widget_name);

        # Create payment by user cart
        $resp = $widget->createPayment($cart);

        # If widget does not support redirects after succeeded payment
        # we need to check it manually
        if ($widget->usesRedirectForSubmit()) {
            
        } else {
            CheckPaymentStatus::dispatch($resp['id'], $widget_name);
        }

        # Create order by cart and payment id
        $order = Order::createFromCart($cart, $resp['id']);

        return $resp;
    }

    public function storeMock(StoreMockRequest $req, Cart $cart)
    {
        $order = Order::createFromCart(
            $cart,
            \Str::random(20),
            Order::PROCESSING
        );

        $cart->clear();

        return response('Order successfully created.', 200);
    }
}
