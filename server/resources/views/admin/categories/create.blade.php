@extends('admin.basic')

@section('content')
	<div class="row m-5">
		<div class="col">
			<div class="card">
				<div class="card-header">
					Create new category
				</div>
				<div class="card-body">
					
					<form method="POST" enctype="multipart/form-data" 
					action="{{ route('admin.categories.create') }}">
						@csrf
						
						<div class="form-group">
							<label for="name">Name: </label>
							<input id="name" name="name" type="text" class="form-control">
						</div>
						@error('name')
						    <div class="alert alert-danger">{{ $message }}</div>
						@enderror

						<div class="form-group">
							<label for="slug">Slug: </label>
							<input id="slug" name="slug" type="text" class="form-control">
						</div>		
						@error('slug')
						    <div class="alert alert-danger">{{ $message }}</div>
						@enderror

						<div class="form-group">
							<label for="description">Description: </label>
							<textarea id="description" name="description"
							type="text" class="form-control"
							></textarea>
						</div>
						@error('description')
						    <div class="alert alert-danger">{{ $message }}</div>
						@enderror
						
						<div class="form-group">
							<label for="image"></label>
							<input type="file" name="image" 
							class="form-control-file" id="image">
						</div>
						@error('image')
						    <div class="alert alert-danger">{{ $message }}</div>
						@enderror

						<div class="form-group">
						    <label for="parent">Select parent category:</label>
						    <select class="form-control" id="parent" name="parent">
								@foreach($categories as $category)
									<option value="{{ $category->getRouteKey() }}">
										{{ $category->name }}
									</option>
								@endforeach
						    </select>					
						</div>
						@error('parent')
						    <div class="alert alert-danger">{{ $message }}</div>
						@enderror


						<button type="submit" class="btn btn-primary">Create</button>	
					</form>			
				</div>
			</div>
		</div>
	</div>
@endsection