<div class="item">
	<a href="{{ route('products.show', $product->getRouteKey()) }}">
		<img class="product-image-sm" src="{{ asset('storage/'.$product->image) }}">	
			
		<div class="product-name-sm">{{ $product->name }}</div>

		<div class="product-price-sm">
			{{ $product->price }}
		</div>
	</a>				
</div>
