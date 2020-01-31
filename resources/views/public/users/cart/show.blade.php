@extends('public.basic')

@section('content')
	<h2 class="content-title">
		Your Cart({{ $cart->getSize() }} items): 
		<span class="price">{{ $cart->getTotalPrice() }}</span>
	</h2>
	
	<div class="items-list">
		@foreach($cart->getItems() as $cart_item)
			@component('public.users.cart.components.cart_item')
				@slot('item', $cart_item)
				@slot('product', $cart_item->getProduct())
			@endcomponent
		@endforeach		
	</div>

	<div class="cart-actions-panel">
		<a href="{{ url()->previous() }}" class="btn btn-primary">Continue shopping</a>
	</div>

@endsection