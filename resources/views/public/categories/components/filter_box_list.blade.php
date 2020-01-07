<ul class="nav flex-column filter-box-list">
	<span class="filter-box-title">{{ $title }}</span>

	@foreach($categories as $category)
		<li class="nav-item">
			<a class="nav-link" 
			href="{{ route('categories.show', $category->slug) }}">
				{{ $category->name }}
			</a>
		</li>
	@endforeach
</ul>