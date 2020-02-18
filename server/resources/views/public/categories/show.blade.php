@extends('public.basic')

@section('content')
	<div class="card">
		<div class="card-header">
			{{ $category->name }}
		</div>
		<div class="card-body">
			{{ $category->description }}
		</div>
	</div>

	<div class="items-list">
		@foreach($products as $product)
			@component('public.products.components.item')
				@slot('product', $product)
			@endcomponent
		@endforeach
	</div>
	
@endsection

@section('filter-box')
	@if($category->hasDescendants())
		@component('public.categories.components.filter_box_list')
			@slot('title', $category->name)
			@slot('categories', $category->children)
		@endcomponent
	@endif
	@component('public.categories.components.filter_box_form')
		@slot('category', $category)
	@endcomponent
@endsection

@section('breadcrumb')
	@foreach($category->ancestors->reverse() as $ansestor)
		<li class="breadcrumb-item">
			<a href="{{ route('categories.show', $ansestor->getRouteKey()) }}">
				{{ $ansestor->name }}
			</a>
		</li>
	@endforeach

	<li class="breadcrumb-item active">
		{{ $category->name }}
	</li>
@endsection