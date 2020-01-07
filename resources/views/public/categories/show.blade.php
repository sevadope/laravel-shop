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

	@foreach($products as $product)
		@component('public.products.components.item')
			@slot('product', $product)
		@endcomponent
	@endforeach
	
@endsection

@section('filter-box')
	@if($category->hasChildren())
		@component('public.categories.components.filter_box_list')
			@slot('title', $category->name)
			@slot('categories', $category->children)
		@endcomponent
	@endif
@endsection

@section('breadcrumb')
	@foreach($category->ancestors as $ansestor)
		<li class="breadcrumb-item">
			<a href="{{ route('categories.show', $ansestor->slug) }}">
				{{ $ansestor->name }}
			</a>
		</li>
	@endforeach

	<li class="breadcrumb-item active">
		{{ $category->name }}
	</li>
@endsection