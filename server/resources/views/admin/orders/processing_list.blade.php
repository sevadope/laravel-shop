@extends('admin.basic')

@section('content')
	@foreach($orders as $order)
		<div class="row">
			<div class="col-12">
				<div class="card border-info">
					<div class="card-header text-center">
						<a href="{{ route('admin.orders.show', $order->getRouteKey()) }}">
							Order ID: {{ $order->getKey() }}
						</a>
					</div>
					<div class="card-body">
						<div class="container">
							<div class="row">
								<div class="col-7">

										<button class="btn btn-secondary" data-toggle="collapse"
										data-target="#{{ $order->payment_id }}">
											Items:
										</button>

										<ul class="list-group collapse" id="{{ $order->payment_id }}">
											@foreach($order->products as $product)
												<li class="list-group-item">
													<h4>
														<a href="{{ route('admin.products.show', $product->getRouteKey()) }}">
															{{ $product->name }}
														</a>
													</h4>
													<h5 class="">Count: {{ $product->pivot->count }}</h5>
													<h5 class="">Options:</h5>
													@foreach($product->pivot->options as $opt_name => $opt_value)
														<button disabled
														class="btn btn-outline-secondary d-flex mb-2">
															{{ "$opt_name: $opt_value" }}
														</button>
													@endforeach
												</li>
											@endforeach											
										</ul>

								</div>
								<div class="col-5">
										<a class="btn btn-success btn-block"
										onclick="
	    							event.preventDefault();
              			document.getElementById('complete-{{ $key = $order->getKey() }}-form').submit();
										">
											Complete order
										</a>
										<form method="post" class="d-none"
										action="{{ 
											route(
												'admin.orders.complete',
												$order->getRouteKey()) 
										}}" id="complete-{{ $key }}-form">
											@csrf
										</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach
@endsection

