@extends('admin.basic')

@section('content')
	<div class="row m-5">
		<div class="col">
			<form method="POST" enctype="multipart/form-data" 
			action="{{ route('admin.categories.update', $category->getRouteKey()) }}">
				@method('PUT')
				@csrf
				
				<div class="form-group">
					<label for="name">Name: </label>
					<input id="name" name="name" type="text" class="form-control" value="{{ $category->name }}">
				</div>
				@error('name')
				    <div class="alert alert-danger">{{ $message }}</div>
				@enderror

				<div class="form-group">
					<label for="slug">Slug: </label>
					<input id="slug" name="slug" type="text" class="form-control" value="{{ $category->slug }}">
				</div>		
				@error('slug')
				    <div class="alert alert-danger">{{ $message }}</div>
				@enderror

				<div class="form-group">
					<label for="description">Description: </label>
					<textarea id="description" name="description"
					type="text" class="form-control"
					>{{ $category->description }}</textarea>
				</div>
				@error('description')
				    <div class="alert alert-danger">{{ $message }}</div>
				@enderror
				
				<div class="form-group">
					<label for="image"></label>
					<input type="file" name="image" 
					class="form-control-file" id="image">
					<img class="img-lg" src="{{ $category->getImageUrl() }}" alt="">
				</div>
				@error('image')
				    <div class="alert alert-danger">{{ $message }}</div>
				@enderror

				<button type="submit" class="btn btn-primary">Update</button>	
			</form>			
		</div>
	</div>

@endsection