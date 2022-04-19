<div class="row">
    <div class="col-12">
      <div class="callout callout-info">
        <h5><i class="fas fa-info"></i> Sales Invoice:</h5>
        {{-- This page has been enhanced for printing. Click the print button at the bottom of the invoice to test. --}}
      </div>
      <!-- Main content -->
      <div class="invoice p-3 mb-3">
        <!-- title row -->
        {{-- <div class="row">
          <div class="col-12">
            <h4>
              <i class="fas fa-building"></i> MASTERERP, NEXTPAGETL.
              <small class="float-right">Date: 2/10/2014</small>
            </h4>
          </div>
          <!-- /.col -->
        </div> --}}
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            Company Info
            <address>
              <strong>{{$companyInfo->name ?? ''}}</strong><br>
              {{$companyInfo->address ?? ''}}
              <br>
              Phone: {{$companyInfo->phone ?? ''}}<br>
              Email: {{$companyInfo->email ?? ''}}
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            Customer Info
            <address>
              <strong>{{$details->customer->name ?? ''}}</strong>
              <br>
              {{$details->customer->address ?? ''}}<br>
              Phone: {{$details->customer->phone ?? ''}}<br>
              Email: {{$details->customer->email ?? ''}}
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b>Invoice {{$details->voucher_no}}</b><br>
            <br>
            <b>Date:</b> {{date('Y-M-d',strtotime($details->date))}}<br>
            <b>Payment Type:</b> {{$details->payment_type}}<br>
            <b>Status:</b> {{$details->status}}
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
          <div class="col-12 table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th>SL</th>
                      <th>Product</th>
                      @if(in_array('batch_no',$activeColumn))
                      <th>Batch No</th>
                      @endif
                      @if(in_array('pack_size',$activeColumn))
                      <th>Pack Size	</th>
                      @endif
                      @if(in_array('pack_no',$activeColumn))
                      <th>Pack No.	</th>
                      @endif
                      <th>Quantity</th>
                      <th>Unit Price</th>
                      <th>Total Price</th>
                  </tr>
              </thead>
              <tbody>
                  @php 
                    $tqty = 0;
                    $tprice = 0;
                  @endphp
                  @foreach($details->salesDetails as $key => $eachDetails)
                  @php 
                      $tqty+=$eachDetails->quantity;
                      $tprice+=$eachDetails->quantity*$eachDetails->total_price;
                    @endphp
                      <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$eachDetails->product->name ?? ''}}</td>
                          @if(in_array('batch_no',$activeColumn))
                          <td>{{$eachDetails->batch_no ?? ''}}</td>
                          @endif
                          @if(in_array('pack_size',$activeColumn))
                          <td>{{$eachDetails->pack_size ?? ''}}</td>
                          @endif
                          @if(in_array('pack_no',$activeColumn))
                          <td>{{$eachDetails->pack_no ?? ''}}</td>
                          @endif
                          <td>{{$eachDetails->quantity ?? ''}}</td>
                          <td>{{number_format($eachDetails->unit_price,2)}}</td>
                          <td>{{number_format($eachDetails->total_price,2)}}</td>
                      </tr>
                  @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="{{helper::getColspan($activeColumn)}}" class="text-right">Sub-Total</th>
                  <th>{{$tqty}}</th>
                  <th>0.00</th>
                  <th>{{helper::pricePrint($tprice)}}</th>
              </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <!-- accepted payments column -->
          <div class="col-9">
            <p class="" style="text-transform: capitalize;"><b> In Word : {{ helper::convert_number_to_words($tprice) }} </b></p>
            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
            {{$details->note}}
            </p>
          </div>
          <!-- /.col -->
          <div class="col-3">
         
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th style="width:50%">Subtotal:</th>
                  <td>{{number_format($details->subtotal,2)}}</td>
                </tr>
                <tr>
                  <th>Tax (9.3%)</th>
                  <td>$10.34</td>
                </tr>
                <tr>
                  <th>Shipping:</th>
                  <td>$5.80</td>
                </tr>
                <tr>
                  <th>Total:</th>
                  <td>{{number_format($details->grand_total,2)}}</td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
          <div class="col-12">
            <a href="invoice-print.html" rel="noopener" onclick="window.print();" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
            <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
              Payment
            </button>
            <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
              <i class="fas fa-download"></i> Generate PDF
            </button>
          </div>
        </div>
      </div>
      <!-- /.invoice -->
    </div><!-- /.col -->
  </div>