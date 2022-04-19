


<div class="invoice-report-header">
    <div class="row">
        <div class="col-md-2">
            <br>
            <img src="http://account.nextpage.info/assets/wysiwyg/logo.png" alt="atil" style="height:60px; ">
        </div>
        <div class="col-md-7 text-center">
            <h2 nowrap="" style="padding: 0px!important;"><b>Nextpage Technology Ltd.</b></h2>
            <h3 style="font-size: 15px!important;padding: 0px!important;margin: 0px!important;">A Leading Software Farm in Bangladesh.</h3>
            @if(!empty($from_date))            
                <p style="padding:0;margin:0;">{{ $from_date ?? '' .' to '. $to_date ?? '' }}</p>
            @endif
            <h3 style="padding:0;margin:0;">{{ $reportTitle ?? 'Report' }}</h3>
        </div>
        <div class="col-md-3" text-right="" style="font-size: 8px">
            <address>
                <b>Nextpage Service Center</b><br> 
                160,Tejgaon I/A,Dhaka-1208<br>Phone: 01700702641
            </address>      
            <address>
                <b>NEXTPAGE Car Showroom</b><br>
                181-182,Tejgaon I/A,Dhaka-1218<br>Phone: 01700702644<br>Tel:+88028878052 
            </address>
        </div>
        <hr>
    </div>
</div>