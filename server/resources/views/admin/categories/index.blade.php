@extends('admin.basic')

@section('content')
	<table class="table">
		<thead>
			<tr>
				<th scope="col">ID</th>
				<th scope="col">Name</th>
				<th scope="col">Slug</th>
				<th scope="col">Popularity</th>
				<th scope="col">Updated At</th>
			</tr>
		</thead>	
		<tbody>
			@foreach($categories as $category)
				<tr>
					<th scope="row">{{ $category->getKey() }}</th>
					<td>
						<a href="#">
						{{ $category->name }}
						</a>
					</td>
					<td>{{ $category->slug }}</td>
					<td>{{ $category->popularity }}</td>
					<td>{{ $category->updated_at }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
		
@endsection