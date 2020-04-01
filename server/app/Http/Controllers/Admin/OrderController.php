<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
	public const PER_PAGE = 20;

    public function index()
    {
    	$orders = Order::with('customer', 'products.options')->paginate(self::PER_PAGE);

    	return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
    	return view('admin.orders.show', compact('order'));	
    }

    public function processingList()
    {
    	$orders = Order::
    		with('customer', 'products')
    		->where('status', Order::PROCESSING)
            ->orderByDesc('created_at')
    		->paginate(self::PER_PAGE);

    	return view('admin.orders.processing_list', compact('orders'));
    }

    public function pendingList()
    {
    	$orders = Order::
    		with('customer', 'products')
    		->where('status', Order::PENDING)
    		->paginate(self::PER_PAGE);

    	return view('admin.orders.pending_list', compact('orders'));	
    }

    public function succeededList()
    {
    	$orders = Order::
    		with('customer')
    		->where('status', Order::SUCCEEDED)
    		->paginate(self::PER_PAGE);

    	return view('admin.orders.succeeded_list', compact('orders'));
    }

    public function complete(Order $order)
    {
        if ($order->status !== Order::SUCCEEDED) {
            $order->setAttribute('status', Order::SUCCEEDED);
            $order->save();

            return back()->with(['msg' => "Order {$order->getKey()} completed."]);
        } 

        throw new \LogicException("Order is already completed.", 1);
        
    }
}
