@extends('admin.basic')

@section('content')
	<div class="row m-5">
		<div class="col">
			<img class="img-lg" src="{{ $product->getImageUrl() }}" alt="">
		</div>
		<div class="col">
			<h2>{{ $product->name }}</h2>
			<div class="">
				@foreach($product->options as $opt)
					{{ $opt->name }}
					<ul class="list-group list-group-horizontal">
						@foreach($opt->values as $val)
							<li class="list-group-item">
								{{ $val->value }}
							</li>
						@endforeach
					</ul>
				@endforeach
			</div>
		</div>
	</div>
	<div class="row m-5">
		<div class="col">
			<h3>Specifications:</h3>
			<ul>		
				@foreach($product->specifications as $spec)
					<li>
						{{ "{$spec->name}: {$spec->value}"}}
					</li>
				@endforeach
			</ul>
		</div>
	</div>
@endsection