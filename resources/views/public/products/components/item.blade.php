<div class="item">
	<a href="{{ route('products.show', $product->getRouteKey()) }}">
		{{ $product->name }}

		<strong> {{ $product->price }} </strong>	
	</a>				
</div>
