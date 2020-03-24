<div class="">
	@error('msg')
		<div class="alert alert-danger">
			{{ $message }}
		</div>
	@enderror

	@if(session()->has('msg'))
		<div class="alert alert-success">
			{{ session('msg') }}
		</div>
	@endisset
</div>