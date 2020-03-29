@extends('admin.basic')

@section('content')
	<div class="row">
		<div class="col">
			<div class="card ">
				<div class="card-header d-flex flex-row justify-content-between
				align-items-end">
					<h3 class="d-flex align-middle">Categories</h3>
					<a href="{{ route('admin.categories.create') }}"
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
								<th scope="col">Updated At</th>
							</tr>
						</thead>	
						<tbody>
							@foreach($categories as $category)
								<tr>
									<th scope="row">{{ $category->getKey() }}</th>
									<td>
										<a href="{{ route('admin.categories.show', $category->getRouteKey()) }}">
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
					{{ $categories->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection