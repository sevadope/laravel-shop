@extends('public.basic')

@section('content')
	
	<div class="product-view">
		<img src="{{ asset('storage/'.$product->image) }}" alt="" class="product-img-lg">
		<div class="product-desc">
			<h3>{{ $product->name }}</h3>

		  	@foreach($product->options as $option)
		  			<h3>{{ $option->name }}</h3>
		  		<ul class="list-group list-group-horizontal">
					@foreach($option->values as $value)
						 <li class="list-group-item">{{ $value->value }}</li>
					@endforeach
				</ul>
			@endforeach					
		</div>
	</div>

@endsection
