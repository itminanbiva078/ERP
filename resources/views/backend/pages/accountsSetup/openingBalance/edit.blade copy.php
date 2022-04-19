@extends('backend.layouts.master')

@section('title')
@endsection

@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    Opening Balance </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                   
                    <li class="breadcrumb-item active"><span>Edit Opening Balance</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Update Opening Balance</h3>
                <div class="card-tools">
                    <a class="btn btn-tool btn-default" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </a>
                    <a class="btn btn-tool btn-default" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="needs-validation" method="POST" action="{{ route('accountSetup.openingBalance.update') }}"
                    novalidate>
                    @csrf
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    {{-- <td  width="35%" class="text-center"><strong>Opening Date</strong></td> --}}
                                    <td  colspan="2">
                                        @if(!empty($formInput) && is_array($formInput))
                                        <div class="form-row" style="width: 100!important">
                                            @foreach ($formInput as $key => $eachInput)
                                            @php htmlform::formfiled($eachInput, $errors, old()) @endphp
                                            @endforeach
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        <table class="table table-bordered">
                                            <tbody>
                                                @if(!empty($inventoryBalance))
                                                <tr>
                                                    <td>Inventory Balance</td>
                                                    <td>{{ helper::pricePrint($inventoryBalance)}}</td>
                                                </tr>
                                                @endif

                                                @if(!empty($customerBalance))
                                                <tr>
                                                    <td>Customer Balance</td>
                                                    <td>{{ helper::pricePrint($customerBalance)}}</td>
                                                </tr>
                                                @endif

                                                @if(!empty($supplierBalance))
                                                <tr>
                                                    <td>Supplier Balance</td>
                                                    <td>{{ helper::pricePrint($supplierBalance)}}</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class=""><strong>Account Head</strong></td>
                                    <td class="text-right"><strong>Debit Balance</strong></td>
                                    <td class="text-right"><strong>Credit Balance</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                @php  
                                    $total_debit_balance=0;
                                    $total_credit_balance=0;
                                @endphp

                                    @foreach($opening as $key => $eachAccount)
                                    <tr>
                                        <td style="text-align: left;font-weight: bold;font-size: 18px;" colspan="3">{{$eachAccount['parent']->name}}</td>
                                    </tr>
                                    @foreach($eachAccount['parentChild'] as $key => $eachChild)
                                    @php 
                                   
                                     $updateValue = App\Models\OpeningBalance::where('company_id',helper::companyId())->where('account_id',$eachChild->id)->first();
                                     $total_debit_balance+=$updateValue->debit ?? 0;
                                     $total_credit_balance+=$updateValue->credit ?? 0;
                                   @endphp
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$eachChild->name}}</td>
                                        <input type="hidden" name="account_id[]" value="{{$eachChild->id}}">
                                        <td><input style="text-align: right" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" class="form-control debit" @php if($updateValue->credit ?? 0 >0): echo "readonly";endif; @endphp value="{{$updateValue->debit ?? ''}}" name="headDebit[]" placeholder="0.00"></td>
                                        <td><input style="text-align: right" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" class="form-control credit" @php if($updateValue->debit ?? 0>0): echo "readonly";endif; @endphp  value="{{$updateValue->credit ?? ''}}" name="headCredit[]" placeholder="0.00"></td>
                                    </tr>
                                    @endforeach
                                @endforeach      
                            <!--End parent query--->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right"><strong>Total Debit and Credit Balance</strong></td>
                                    <td class="text-right"><strong> <span class="sub_total_debit">@php echo $total_debit_balance; @endphp</span></strong></td>
                                    <td class="text-right"><strong> <span class="sub_total_credit">@php echo $total_credit_balance; @endphp</span></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    <button class="btn btn-info" id="sbtn" type="submit"><i class="fa fa-save"></i>&nbsp;Update</button>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

            </div>
        </div>
    </div>
    <!-- /.col-->
</div>
@endsection

@section('scripts')
<script>
$('tbody,tfoot').delegate( 'input.debit,input.credit', 'keyup',  function() {
    var tr = $(this).closest('tr');
    var debit = (tr.find('input.debit').val()-0);
    var credit = (tr.find('input.credit').val()-0);

    if(debit === credit){
        tr.find('input.credit').attr('readonly',false);
        tr.find('input.debit').attr('readonly',false);
    }else if(debit > 0){
        tr.find('input.credit').attr('readonly',true);
        tr.find('input.debit').attr('readonly',false);
    }else{
        tr.find('input.debit').attr('readonly',true);
        tr.find('input.credit').attr('readonly',false);
    }
    $(this).removeClass("border border-danger");
    $(this).addClass("border border-success");
    
    calculation();
    checkDebitAndCreditAmount();
});


function checkDebitAndCreditAmount(){
    let tdebit =  parseFloat($('.sub_total_debit').text() - 0);
    let tcredit =  parseFloat($('.sub_total_credit').text() - 0);
   
    console.log(tdebit);
    console.log(tcredit);


    if(tdebit == tcredit){
        console.log("true");
        console.log(tcredit);
        console.log(tdebit);
       
        $('#sbtn').attr('disabled',false);
    }else{
        console.log("false");
        console.log(tcredit);
        console.log(tdebit);
       
        $('#sbtn').attr('disabled',true);
    }
}


function calculation() {
           
           var total_debit_price = 0;
           var total_credit_price = 0;
           $('.debit').each(function(i, e) {
               var total_price = parseFloat($(this).val() - 0);
               total_debit_price += total_price;
           });
           $('.credit').each(function(i, e) {
               var total_price = parseFloat($(this).val() - 0);
               total_credit_price += total_price;
           });

           $('.sub_total_debit').text((total_debit_price));
           $('.sub_total_credit').text((total_credit_price));

       }

</script>
@endsection

