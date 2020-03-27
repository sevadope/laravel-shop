<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderCollection;

class OrderController extends Controller
{
    public function index()
    {
    	$orders = auth()->user()->orders;

    	return new OrderCollection($orders);
    }
}
