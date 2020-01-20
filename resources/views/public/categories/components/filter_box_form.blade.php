<div class="card">
	<div class="card-body">
		<form method="get" action="{{ route('categories.show', $category->getRouteKey()) }}">

			<div class="form-group row">
				<label for="min_price">Min price:</label>
				<input id='min_price' name="min_price" type="text"
				class="form-control" value="{{ old('min_price') }}">
                @error('min_price')
                	{{ $message }}
                @enderror				
				<label for="max_price">Max price:</label>
				<input id='max_price' name="max_price" type="text" 
				class="form-control" value="{{ old('max_price') }}">
                @error('max_price')
                	{{ $message }}
                @enderror
			</div>
        	<button type="submit" class="btn btn-primary">
        	    Filter
        	</button>
		</form>		
	</div>

</div>
