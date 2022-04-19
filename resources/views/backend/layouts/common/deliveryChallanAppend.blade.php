
 @if(!empty($invoiceDetails))
 @foreach($invoiceDetails as $parent => $details)

 @php
 $detailsInfo = '';
 if(!empty($details->salesDetails)):
    $detailsInfo=$details->salesDetails;
endif;


 @endphp
 @foreach($detailsInfo as $key => $value)
 @if($value->quantity-$value->approved_quantity >=1)
 <tr class="new_item<?php echo $parent + $key + 99; ?>">

     @if(in_array('product_id',$activeColumn))

     <td>
         <select name="product_id[]" class="form-control product_id select2 " id=""
             placeholder="Type Product">
             <option value="" selected="" disabled="" data-select2-id="55">(:-Select Product-:)</option>
             @foreach($products as $key => $product)
             <option @if($value->product_id == $product->id) selected @endif
                 value="{{$product->id}}">{{$product->name}}</option>
             @endforeach
         </select>
     </td>
     @endif
     @if(in_array('batch_no',$activeColumn))
     <td><input type="text" name="batch_no[]" class="form-control batch_no border-success border" id=""
     readonly="readonly"  placeholder="Batch No" value="{{ $value->batch_no}}"></td>
     @endif

     @if(in_array('pack_size',$activeColumn))
     <td><input type="number" required=""  name="pack_size[]"
             class="form-control pack_size decimal border border-success" id="" placeholder="Pack Size"
             readonly="readonly" value="{{$value->pack_size}}"></td>
     @endif

     @if(in_array('pack_no',$activeColumn))
     <td><input type="number" required=""  name="pack_no[]"
             class="form-control pack_no decimal border-success border" id="" placeholder="Pack No."
             readonly="readonly" value="{{$value->pack_no}}"></td>
     @endif

     @if(in_array('quantity',$activeColumn))
     <td><input type="number" required=""  name="quantity[]"
             class="form-control quantity decimal" id="" placeholder="Quantity" value="{{$value->quantity}}"
             readonly="readonly" readonly="readonly">
     </td>
     @endif
     <td><input type="number" required=""  name="remaining_quantity[]" readonly  class="form-control remaining_quantity decimal" id="" placeholder="Remaining" value="{{$value->quantity-$value->approved_quantity}}"></td>
     <td><input type="number" required=""  name="approved_quantity[]"  class="form-control approved_quantity decimal" id="" placeholder="Approved Quantity" value="{{$value->quantity-$value->approved_quantity}}"></td>
     
    <td class="text-center"><button del_id="<?php echo $parent + $key + 99; ?>"
             class="delete_item btn btn-danger" type="button" href="javascript:;" title="Are you Remove?"><i
                 class="fa fa-minus"></i></button>
     </td>
 </tr>
@endif
 @endforeach
 @endforeach
 @endif

