
<table class="cart-item">
	<tr>
		<td>
			<img class="product-image-sm" src="{{ $product->getImageUrl() }}">	
		</td>
		<td>
			<a href="{{ route('products.show', $product->getRouteKey()) }}">
				{{ $product->name }}
			</a>
		</td>
		<td>
			<div>{{ $item->getCount() }} items</div>
			<span class="price">{{ $product->price }}</span> each
		</td>
		<td>Subtotal: <span class="price">{{ $item->getTotalPrice() }}</span></td>
	</tr>
</table>
