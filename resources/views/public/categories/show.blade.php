@extends('layouts.basic')

@section('content')
	<div class="card">
		<div class="card-header">
			{{ $category->name }}
		</div>
		<div class="card-body">
			{{ $category->description }}
		</div>
	</div>

	@foreach($products as $product)
		@component('public.products.components.item')
			@slot('product', $product)
		@endcomponent
	@endforeach
	
@endsection

@section('filter-box')
	@if($category->children()->count() !== 0)
		@component('public.categories.components.filter_box_list')
			@slot('title', $category->name)
			@slot('categories', $category->getAllChildren())
		@endcomponent
	@endif
@endsection