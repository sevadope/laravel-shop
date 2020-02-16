@extends('public.basic')

@section('content')

	<div class="product-view">
		<div class="product-slider">
			<img src="{{ $product->getImageUrl() }}" alt="" class="product-img-lg">
		</div>
		<div class="product-desc">
			<h3>{{ $product->name }}</h3>		
			<ul class="">
				@foreach($product->specifications as $spec)
					<li class="">
						{{ $spec->name.': '.$spec->value }}
					</li>
				@endforeach		
			</ul>
		</div>
		<div class="product-actions">
			<add-to-cart-form
			auth="{{ auth()->check() }}"
			product_key="{{ $product->getKey() }}"
			:options="{{$product->options->toJson()}}"
			form_action="{{ route('users.cart.add') }}">
			</add-to-cart-form>			
		</div>
	</div>

@endsection
