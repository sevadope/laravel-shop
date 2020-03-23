@extends('admin.basic')

@section('content')
	<div class="row m-5">
		<div class="col">
			<h2>{{ $category->name }}</h2>
		</div>
	</div>
	<div class="row m-5">
		<div class="col">
			<img class="img-lg" src="{{ $category->getImageUrl() }}" alt="">
		</div>
		<div class="col">
			{{  $category->description }}
		</div>
	</div>
	<div class="row m-5">
		<div class="col">
			<a href="{{ route('admin.categories.edit', $category->getRouteKey()) }}" 
			class="btn btn-primary">
				Edit
			</a>
			<a href="#" class="btn btn-danger">Delete</a>
		</div>
	</div>
@endsection