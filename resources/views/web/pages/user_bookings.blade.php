@extends('web.layouts.master')
@section('title')
Booking List
@endsection

@section('frontend-content')

<div class="booking-profile">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="property-details-page">
		        <div class="property-title">
		          <h3 >Profile</h3>
		        </div>
		        <div class="property-slide-content">
		          <p> Name: {{$user_info->name}}</p>
		          <p> Phone: {{$user_info->phone}}</p>
				  @if(!empty($customer_info))
		          <p> Address: {{$customer_info->address}}</p>
				  @endif
		      	</div>

		    	</div>
			</div>
		    <div class="col-md-9">
		      	<div class="property-details-page">
					<div class="property-title">
						<h3 >Booking List</h3>
					</div>
					<div class="property-slide-content">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Booking Id</th>
										<th>Booking Date</th>
										<th>Entry Date</th>
										<th>Exit Date</th>
										<th>Total Bill</th>
										<th>Paid Bill</th>
										<th>Balance</th>
										<th>Payment Status</th>
										<th>Booking Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@if(!empty($bookings))
										@foreach($bookings as $value)
											<tr>
												<td>{{$value->id}}</td>
												<td>{{date_format($value->created_at,"Y-m-d")}}</td>
												<td>{{$value->entry_date}}</td>
												<td>{{$value->exit_date}}</td>
												<td>{{$value->grand_total}} TK</td>
												<td>{{$value->advance_paid}} TK</td>
												<td>{{$value->due_amount}} TK</td>
												<td><?php echo helper::statusBar($value->payment_status);?></td>
												<td><?php echo helper::statusBar($value->booking_status);?></td>

												<td>
													@if($value->booking_status =='Pending')
													<a class="btn btn-danger btn-sm  "  onclick="return confirm('are you sure?')" href="{{route('booking_delete',$value->id)}}"><i class="fa fa-trash"></i> Cancel ?</a></td>
													@endif
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
		    	</div>
			</div>
		</div>
	</div>
</div>
@endsection