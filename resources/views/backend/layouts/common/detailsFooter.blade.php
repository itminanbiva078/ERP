<div class="voucher-footer">
    <div class="row">
        <div class="col-md-4">
            <p class="text-center "><span class="border-middle" > {{$details->createdBy->name ?? ''}} </span><br>Prepared By</p>                        
        </div>
        <div class="col-md-4">
            <p class="text-center"><span class="border-middle" ></span><br>Checked By</p>           
        </div>
        <div class="col-md-4">
            <p class="text-center"><span class="border-middle" >{{$details->approvedBy->name ?? ''}}</span><br>Approved By </p>             
        </div>
    </div>

    <div class="note">
        <p>Time of Printing: @php echo date('h:i:s a'); @endphp & Date of Printing: @php echo date('Y-m-d'); @endphp</p>
        <p class="text-center">{{helper::companyInfo()->address}}, Tel/FAX: {{helper::companyInfo()->phone}}, E-mail: {{helper::companyInfo()->email}},Phone: {{helper::companyInfo()->website}}</p>
    </div>
</div>

