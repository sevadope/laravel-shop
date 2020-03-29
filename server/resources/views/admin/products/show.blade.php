@extends('admin.basic')

@section('content')
	<div class="row m-5">
		<div class="col">
			<div class="card">
				<div class="row">
					<div class="col">
						<div class="card-header text-center">
							{{ $product->name }}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<img class="img-lg" src="{{ $product->getImageUrl() }}" alt="">
					</div>
					<div class="col">
						<div class="card-body">
							<h3 class="card-title">
								Options:
							</h3>
							<div class="card-text">
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
							<h3 class="card-title mt-3">Specifications:</h3>
							<ul>		
								@foreach($product->specifications as $spec)
									<li>
										{{ "{$spec->name}: {$spec->value}"}}
									</li>
								@endforeach
							</ul>											
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection