@extends('admin.basic')

@section('content')
	<div class="row">
		<div class="col">
			<div class="card ">
				<div class="card-header d-flex flex-row justify-content-between
				align-items-end">
					<h3 class="d-flex align-middle">Pending Orders</h3>				
				</div>
				<div class="card-body">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Customer</th>
								<th scope="col">Payment ID</th>
								<th scope="col">Total Price</th>
								<th scope="col">Status</th>
								<th scope="col">Created at</th>
							</tr>
						</thead>	
						<tbody>
							@foreach($orders as $order)
								<tr>
									<td>
										<a href="{{ route('admin.orders.show', $order->getRouteKey()) }}">
										{{ $order->getKey() }}
										</a>
									</td>
									<td>
										<a href="#">
											{{ $order->customer->name }}
										</a>
									</td>
									<td>
										{{ $order->payment_id }}
									</td>
									<td>
										<div class="price">
											{{ $order->total_price }}
										</div>
									</td>
									<td>
										<h4>
											<span 
											class="badge badge-pill 
											badge-{{ $order->status }}">
												{{ $order->status }}
											</span>
										</h4>
										</td>
									<td>{{ $order->created_at }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					{{ $orders->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection

