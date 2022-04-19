@if(!empty($invoiceDetails))
    @foreach($invoiceDetails as $parent => $details)

        @php
        $detailsInfo = '';
        if(!empty($details->purchasesDetails)):
        $detailsInfo=$details->purchasesDetails;
        endif;
        @endphp
            @foreach($detailsInfo as $ekey => $value)
                @if($value->quantity-$value->approved_quantity >=1)
                <tr class="new_item<?php echo $parent + $ekey + 99; ?>">
                    @if(in_array('product_id',$activeColumn))
                    <td>
                        {{-- this loop only for product name pick need to optimize --}}
                        @foreach($products as $key => $product)
                            @if($value->product_id == $product->id)
                               <input type="hidden" pname="{{$product->name}}" name="product_id[]" value="{{$value->product_id}}" class="product_id"/>
                            @endif
                        @endforeach
                        <select disabled class="form-control" id=""  placeholder="Type Product">
                            <option value="" selected="" disabled="" data-select2-id="55">(:-Select Product-:)</option>
                            @foreach($products as $key => $product)
                            <option @if($value->product_id == $product->id) selected @endif
                                value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    @endif

                    <td><input type="text" required=""  name="batch_no[]"  class="form-control batch_no" id="" placeholder="" ></td>

                    @if(in_array('pack_size',$activeColumn))
                    <td><input type="number" required=""  name="pack_size[]"  class="form-control pack_size decimal border border-success" id="pack_size_{{$value->product_id}}" placeholder="Pack Size"  readonly="readonly" value="{{$value->pack_size}}"></td>
                    @endif

                    @if(in_array('pack_no',$activeColumn))
                    <td><input type="number" required=""  name="pack_no[]" class="form-control pack_no decimal border-success border" id="pack_no_{{$value->product_id}}" placeholder="Pack No."  value="0"></td>
                    @endif

                    @if(in_array('quantity',$activeColumn))
                    <td><input type="number" required=""  name="quantity[]"  class="form-control quantity decimal" id="quantyty_{{$value->product_id}}" placeholder="Quantity" value="{{$value->quantity}}"   readonly="readonly" readonly="readonly">
                    </td>
                    @endif
                    <td>
                        <input type="hidden" class="mainQuantity_{{$value->product_id}}"  value="{{$value->quantity-$value->approved_quantity}}"/>

                        <input type="hidden" required=""   readonly id="apid_{{$value->product_id}}"  class="form-control actual_remaining_quantity decimal" id="" placeholder="Remaining" value="{{$value->quantity-$value->approved_quantity}}">
                        <input type="text" required=""  name="remaining_quantity[]" readonly id="pid_{{$value->product_id}}"  class="form-control remaining_quantity main_remaining_qty" id="" placeholder="Remaining" value="{{$value->quantity-$value->approved_quantity}}">
                    </td>
                    <td>
                        <input type="number" required=""  readonly name="approved_quantity[]"  class="form-control approved_quantity_{{$value->product_id}} approved_quantity decimal" id="approved_qty_{{$value->product_id}}" placeholder="Approved Quantity" value="{{$value->quantity-$value->approved_quantity}}"></td>
                    <td class="text-center"><button del_id="<?php echo $parent + $ekey + 99; ?>"  class="delete_item btn btn-danger" type="button" href="javascript:;" title="Are you Remove?"><i    class="fa fa-minus"></i></button> </td>
                </tr>
                @endif
            @endforeach
        @endforeach
    @endif

