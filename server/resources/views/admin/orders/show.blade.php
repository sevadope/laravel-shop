@extends('admin.basic')



@section('content')
	<div class="row m-5">
		<div class="col">
			<div class="card">
				<div class="row">
					<div class="col">
						<div class="card-header text-center">
							ID: {{ $order->getKey() }}
						</div>
					</div>
				</div>
				<div class="row mt-3 text-center">
					<div class="col">
						<h2>
							Total Price: 
							<span class="price">
								{{ $order->total_price }}
							</span>
						</h2>	
					</div>
					<div class="col">
						<h2>
							Total Count: {{ $order->total_count }}
						</h2>
					</div>						
				</div>
				<div class="row">
					<div class="col-12">
						<div class="m-5">						
							<h3 class="card-title mt-3">Products:</h3>
							<ul>		
								@foreach($order->products as $product)
									<div 
									class="d-inline-flex card text-center m-4">
										<img src="{{ $product->getImageUrl() }}" class="card-img-top img-md" alt="">

										<a href="{{ route('admin.products.show', $product->getRouteKey()) }}">
										   	{{ $product->name }}
										</a>
										<h5 class="price">
											{{ $product->price }}
										</h5>		
										<h5>Count: {{  $product->pivot->count }}</h5>
										<h5>Options:</h5>
										@foreach($product->pivot->options as $opt_name => $opt_value)
											<button disabled
											class="btn btn-outline-secondary">
												{{ "$opt_name: $opt_value" }}
											</button>
										@endforeach
									</div>
								@endforeach
							</ul>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection