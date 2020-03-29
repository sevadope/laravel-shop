<div class="d-inline-flex card text-center m-4">
		<img src="{{ $item->getImageUrl() }}" class="card-img-top img-md" alt="">

	<a href="{{ route('admin.products.show', $item->getRouteKey()) }}">
	   	{{ $item->name }}
	</a>
	    <h5 class="price">{{ $item->price }}</h5>		
</div>