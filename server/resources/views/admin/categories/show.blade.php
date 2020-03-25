@extends('admin.basic')

@section('content')
	<div class="row m-5">
		<div class="col">
			<h2>{{ $category->name }}</h2>
		</div>
	</div>
	<div class="row m-5">
		<div class="col">
			<h4>Ancestors:</h4>
			<ul class="list-group">
				@foreach($category->ancestors as $anc)
					<li class="list-group-item">
						<a href="{{ route('admin.categories.show', $anc->getRouteKey()) }}">
							{{ $anc->name }}
						</a>
					</li>
				@endforeach
			</ul>

			<h4>Children:</h4>
			<ul class="list-group">
				@foreach($category->children as $child)
					<li class="list-group-item">
						<a href="{{ route('admin.categories.show', $child->getRouteKey()) }}">
							{{ $child->name }}
						</a>
					</li>
				@endforeach
			</ul>
		</div>
		<div class="col">
			<img class="img-lg" src="{{ $category->getImageUrl() }}" alt="">
		</div>
		<div class="col">
			{{  $category->description }}
		</div>
	</div>
	<div class="row m-5">
		<div class="col">
			
		</div>
		<div class="col">
			<a href="{{ route('admin.categories.edit', $category->getRouteKey()) }}" 
			class="btn btn-primary">
				Edit
			</a>
			<a href="#" class="btn btn-danger"
			onclick="
				event.preventDefault();
				document.getElementById('delete-form').submit();
			">
				Delete
			</a>
			<form class="d-none" id="delete-form" name="delete-form" method="post" 
			action="{{ route('admin.categories.delete', $category->getRouteKey()) }}">
				@method('DELETE')
				@csrf
			</form>
		</div>
	</div>
	<div class="row m-5">
		<h1>Products:</h1>
		<div class="">
			@foreach($products as $product)
				@component('admin.components.product_card')
					@slot('item', $product)
				@endcomponent
			@endforeach
		</div>
	</div>
@endsection