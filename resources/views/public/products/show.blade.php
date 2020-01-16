@extends('public.basic')

@section('content')
	<div class="card">
		<div class="card-body">
	    	<h5 class="card-title">{{ $product->name }}</h5>
	    	<h6 class="card-subtitle mb-2 text-muted">{{ $product->getKey() }}</h6>
	    	<p class="card-text">{{ $product->description }}</p>
	    	<h2>{{ $product->price }}</h2>
	  	</div>

	  	@foreach($product->options as $option)
	  			<h3>{{ $option->name }}</h3>
	  		<ul class="list-group list-group-horizontal">
				@foreach($option->values as $value)
					 <li class="list-group-item">{{ $value->value }}</li>
				@endforeach
			</ul>
		@endforeach
		
	</div>
@endsection
