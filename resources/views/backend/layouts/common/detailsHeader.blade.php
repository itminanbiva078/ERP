<div class="row invoice-info">
    <div class="col-sm-3 invoice-col">
      Company Info
      <address>
        <strong>{{$companyInfo->name ?? ''}}</strong><br>
        {{$companyInfo->address ?? ''}}
        <br>
        Phone: {{$companyInfo->phone ?? ''}}<br>
        Email: {{$companyInfo->email ?? ''}}
      </address>
    </div>
      

    @if(!empty($details->supplier))
      <!-- /.col -->
    <div class="col-sm-3 invoice-col">
      Supplier Info
      <address>
        <strong>{{$details->supplier->name ?? ''}}</strong><br>
        {{$details->supplier->address ?? ''}}<br>
        Phone: {{$details->supplier->phone ?? ''}}<br>
        Email: {{$details->supplier->email ?? ''}}
      </address>
    </div>
    @endif
    @if(!empty($details->customer))
      <!-- /.col -->
    <div class="col-sm-3 invoice-col">
      Customer Info
      <address>
        <strong>{{$details->customer->name ?? ''}}</strong><br>
        {{$details->customer->address ?? ''}}<br>
        Phone: {{$details->customer->phone ?? ''}}<br>
        Email: {{$details->customer->email ?? ''}}
      </address>
    </div>
    @endif
    <!-- /.col -->
    <div class="col-sm-3 invoice-col">
        @if(!empty($details->voucher_no))
         <b>Invoice: {{$details->voucher_no ?? ''}}</b><br>
        @endif
        @if(!empty($details->date))
        <b>Date:</b> {{ helper::get_php_date($details->date)}}<br>
        @endif
        @if(!empty($details->payment_type))
        <b>Payment Type:</b> {{$details->payment_type}}<br>
        @endif
        @if(!empty($details->department))
        <b>Department : </b>{{$details->department->name ?? ''}}<br>
        @endif
        @if(!empty($details->order_status))
        <b>Order Status:</b> @php echo helper::statusBar($details->order_status) @endphp<br>
        @endif
        @if(!empty($details->purchases_status))
        <b>Purchases Status:</b> @php echo helper::statusBar($details->purchases_status) @endphp<br>
        @endif
        @if(!empty($details->requisition_status))
        <b> Requisition Status:</b> @php echo helper::statusBar($details->requisition_status) @endphp <br>
        @endif
        @if(!empty($details->purchases_order_status))
        <b> Order Status: </b> @php echo helper::statusBar($details->purchases_order_status) @endphp <br>
        @endif

        @if(!empty($details->sales_status))
        <b> Sales Status: </b> @php echo helper::statusBar($details->sales_status) @endphp <br>
        @endif

        @if(!empty($details->service_status))
        <b> Service Status: </b> @php echo helper::statusBar($details->service_status) @endphp <br>
        @endif
        @if(!empty($details->quatation_status))
        <b> Quatation Status: </b> @php echo helper::statusBar($details->quatation_status) @endphp <br>
        @endif
       
        @if(!empty($details->purchases->voucher_no))
        <b>Purchases Voucher :</b> {{$details->purchases->voucher_no ?? ''}}<br>
        @endif

        @if(!empty($details->mrr_status))
        @if(helper::mrrIsActive())
        <b>Mrr Status:</b> @php echo helper::statusBar($details->mrr_status) @endphp
        @endif
        @endif
       
        @if(!empty($details->challan_status))
        <b>Challan Status:</b> @php echo helper::statusBar($details->challan_status) @endphp
        @endif


        @if(!empty($details->receive_status))
        @if(helper::isDeliveryChallanActive())
        <b>Receive Status:</b> @php echo helper::statusBar($details->receive_status) @endphp
        @endif
        @endif
       
    </div>
    <!-- /.col -->
  </div>