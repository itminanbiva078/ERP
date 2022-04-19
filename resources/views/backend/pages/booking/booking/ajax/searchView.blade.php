<div class="row">
    @if(!empty($freeRoomList) && count($freeRoomList) > 0 )
        @foreach($freeRoomList as $key => $eachRoom)
      
                <div class="col-md-3 px-15">
                    <div class="card">
                        @if(!empty($eachRoom->image))
                          <img class="card-img-top" src="{{ asset(helper::imageUrl($eachRoom->image ?? '')) }}" alt="Card image cap">
                        @else
                          <img class="card-img-top" src="https://hotelmohona.com/storage/uploads/product/37/3801647414977.jpeg" alt="Card image cap">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title"> {{$eachRoom->name ?? ''}}- Room:  {{$eachRoom->productDetails->room_no ?? ''}} </h5>
                            <div class="product-price">
                                <span> <b> Number Of Bed :</b> {{$eachRoom->productDetails->number_of_room ?? ''}}</span>
                                <span> <b> {{$eachRoom->sale_price}} Tk </b> </span>
                            </div>
                            <div class="section-btn">
                                <a target="_blank" href="{{route('property_details',$eachRoom->id)}}" class="btn btn-primary"> Go to Details </a>
                                {{-- <a  href="{{route('booking.selectCreate',$eachRoom->id)}}" class="btn btn-primary"> Book Now </a> --}}
                                <a  class="btn btn-primary bookNow" onclick="bookNow('<?php echo $eachRoom->id?>','<?php echo $eachRoom->name;?>','<?php echo $eachRoom->sale_price;?>')"> Book Now </a>
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach
    @else 
        <div class="alert alert-info">
            <strong>Sorry!</strong> This search keyword have no avaialble room.
        </div>

    @endif
    

</div>