@extends('admin.basic')

@section('content')
	<a href="#" class="btn btn-success">
		New
	</a>
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
					<td>{{ $product->category->slug }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	{{ $products->links() }}	
@endsection