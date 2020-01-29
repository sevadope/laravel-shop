<div class="item">
	<a href="{{ route('categories.show', $category->getRouteKey()) }}">
		<img class="category-image" src="{{ asset('storage/'.$category->image) }}">
		
		<div>{{ $category->name }}</div>
	</a>				
</div>
