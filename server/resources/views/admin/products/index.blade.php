@extends('admin.basic')

@section('content')
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-header d-flex flex-row justify-content-between
				align-items-end">
					<h3 class="d-flex align-middle">Products</h3>
					<a href="#"
					class="btn btn-success float-right d-flex">
						New
					</a>					
				</div>
				<div class="card-body">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Name</th>
								<th scope="col">Slug</th>
								<th scope="col">Popularity</th>
								<th scope="col">Category</th>
							</tr>
						</thead>	
						<tbody>
							@foreach($products as $product)
								<tr>
									<th scope="row">{{ $product->getKey() }}</th>
									<td>
										<a href="{{ route('admin.products.show', $product->getRouteKey()) }}">
										{{ $product->name }}
										</a>
									</td>
									<td>{{ $product->slug }}</td>
									<td>{{ $product->popularity }}</td>
									<td>
										<a href="{{ route(
											'admin.categories.show',
											$product->category->getRouteKey()
										) }}">
											{{ $product->category->name }}
										</a>
										
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					{{ $products->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection