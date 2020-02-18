<div class="item">
	<a href="{{ route('products.show', $product->getRouteKey()) }}">
		<img class="product-image-sm" src="{{ $product->getImageUrl() }}">	
			
		<div>{{ $product->name }}</div>

		<div class="price">
			{{ $product->price }}
		</div>
	</a>				
</div>
