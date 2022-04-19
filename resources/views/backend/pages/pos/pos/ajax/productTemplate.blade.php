<div class="row">
    @if(!empty($products) && count($products) > 0)
        @foreach($products as $key => $value )
            <div class="col-md-3 col-sm-4 col-xs-6">
                    @if(!empty($value->appendQty))
                      <div class="selespos-product activeDiv">
                    @else 
                      <div class="selespos-product">
                    @endif
                    <a product_id="{{$value->id}}" class="product_id" href="javascript:void(0)">
                        <div class="card">
                            @if(!empty($value->appendQty))
                            <div class="quantityBatch"><span class="active_qty active_id_{{$value->id}}">{{$value->appendQty}}</span></div>
                            @else 
                           <div class="batch"><span class="active_qty "></span></div>
                           @endif
                            <img class="card-img-top" style="height: 100px!important" src="{{ asset(helper::imageUrl($value->image ?? '')) }}" alt="Card image cap">
                            <div class="card-body">
                                <h5>{{$value->name}}</h5>
                                <h5>৳ {{$value->sale_price}}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach  
    @else 
    <div class="col-md-12">
        <div class="alert alert-info alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Info!</strong> Sorry your given search keyword have no product!!.
        </div>
    </div>
    @endif
</div>