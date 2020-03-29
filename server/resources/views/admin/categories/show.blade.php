@extends('admin.basic')

@section('content')
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="row">

					<div class="col">
						<img src="{{ $category->getImageUrl() }}" alt="">
					</div>

					<div class="col">
						<div class="card-body">
							<h3 class="card-title">{{ $category->name }}</h3>
							<p class="card-text">
								{{ $category->description }}
							</p>
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

				</div>
				<div class="row m-2">
					<div class="col">
						@if(!$category->ancestors->isEmpty())
							<h4>Ancestors:</h4>
							<ul class="list-group list-group-horizontal">
								@foreach($category->ancestors as $anc)
									<li class="list-group-item">
										<a href="{{ route('admin.categories.show', $anc->getRouteKey()) }}">
											{{ $anc->name }}
										</a>
									</li>
								@endforeach
							</ul>
						@endif

						@if(!$category->children->isEmpty())
							<h4>Children:</h4>
							<ul class="list-group list-group-horizontal">
								@foreach($category->children as $child)
									<li class="list-group-item">
										<a href="{{ route('admin.categories.show', $child->getRouteKey()) }}">
											{{ $child->name }}
										</a>
									</li>
								@endforeach
							</ul>
						@endif
					</div>					
				</div>
				<div class="row m-2">
					<h3>Products:</h3>
					<div class="">
						@foreach($products as $product)
							@component('admin.components.product_card')
								@slot('item', $product)
							@endcomponent
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection