<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\InitPaymentRequest;
use App\Models\Cart;
use App\Services\PaymentService;
use App\Models\Order;

class PaymentController extends Controller
{
    public function init(
    	InitPaymentRequest $req,
        PaymentService $service,
        Cart $cart
    )
    {
    	$client_name = $req->validated()['client'];

        $client = $service->getClient($client_name);

        $resp = $client->createPayment($cart);

        $order = Order::createFromCart($cart, $resp['id']);
        return $resp;
    }
}
