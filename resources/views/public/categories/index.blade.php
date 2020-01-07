@extends('public.basic')

@section('content')

	@isset($categories)
		@foreach($categories as $category)
			@component('public.categories.components.item')
				@slot('category', $category)
			@endcomponent
		@endforeach
	@endisset
	
@endsection
