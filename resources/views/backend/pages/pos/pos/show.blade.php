<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Invoice</title>
        <base href="http://localhost/istiaq/pos/"/>
        <meta http-equiv="cache-control" content="max-age=0"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="expires" content="0"/>
        <meta http-equiv="pragma" content="no-cache"/>



        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
        <link href="{{ asset('frontant/css/style.css') }}" rel="stylesheet">
        <!-- Scripts -->
    
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/admin.js') }}" defer></script>

       
        
        <style type="text/css" media="all">
            body { color: #000; }
            #wrapper { max-width: 480px; margin: 0 auto; padding-top: 20px; }
            .btn { border-radius: 0; margin-bottom: 5px; }
            .bootbox .modal-footer { border-top: 0; text-align: center; }
            h3 { margin: 5px 0; }
            .order_barcodes img { float: none !important; margin-top: 5px; }
            @media print {
                .no-print { display: none; }
                #wrapper { max-width: 480px; width: 100%; min-width: 250px; margin: 0 auto; }
                .no-border { border: none !important; }
                .border-bottom { border-bottom: 1px solid #ddd !important; }
            }
        </style>
    </head>

    <body>
        <div id="wrapper">
            <div id="receiptData">
                <div class="no-print"></div>
                <div id="receipt-data">
                    <div class="text-center">
                        <h3 style="text-transform:uppercase;">PARTY TIME</h3>
                        <p>Shop No: 1B-010A, Jamuna Future Park, Dhaka Bangladesh</p>                
                        <p>Tel : 01712026972</p>                
                    </div>
                   
                    <p>
                       <span class="text-left">Date:2022-02-02</span>
                       <span class="text-right" style="text-align: right">Sales Person: Customer 1 </span>
                    
                    </p>
                   
                    <div style="clear:both;"></div>
                    <table class="table table-striped table-condensed">
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($details->posDetails as $key => $eachProduct): 
                            
                            
                            ?>
                                <tr>
                                    <td colspan="2" class="no-border">
                                        #{{ $sl}}: &nbsp;&nbsp;{{ $eachProduct->product->name ?? ''; }}<span class="pull-right">*NT</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-border border-bottom">
                                        <?php echo $eachProduct->quantity; ?> x <?php echo $eachProduct->unit_price; ?>
                                    </td>
                                    <td class="no-border border-bottom text-right">
                                        <?php echo $eachProduct->quantity * $eachProduct->unit_price; ?>
                                    </td>
                                </tr>
                                <?php $sl++; ?>
                            <?php endforeach; ?>    
                        </tbody>
                        <tfoot>
                          
                            <tr>
                                <th>Grand Total:</th>
                                <th class="text-right"><?php echo $details->subtotal; ?></th>
                            </tr>
                            <?php if ($details->discount > 0) { ?>
                                <tr>
                                    <th>Discount(-):</th>
                                    <th class="text-right"><?php echo $details->discount; ?></th>
                                </tr>   
                            <?php } ?>
                            <?php if ($details->others_charge > 0) { ?>
                                <tr>
                                    <th>Others Charge(+):</th>
                                    <th class="text-right"><?php echo $details->others_charge; ?></th>
                                </tr>   
                            <?php } ?>

                            <tr>
                                <th>Net Total:</th>
                                <th class="text-right"><?php echo $details->grand_total; ?></th>
                            </tr>
                        </tfoot>
                    </table>
                   
                    <p class="text-center" style="font-size: 10px "> Thank you for shopping with us. Please come again</p>  
                </div>

                <div class="order_barcodes text-center">
                    <span style="font-size:8px;"> Software Developed By Nextpagetl</span>
                </div>
                <div style="clear:both;"></div>
            </div>

            <div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
                <hr>
                <span class="pull-right col-xs-12">
                    <button onclick="window.print();" class="btn btn-block btn-primary">Print</button>                
                </span>

                <span class="col-xs-12">
                    <a class="btn btn-block btn-success" href="{{ route('pos.pos.index') }}">Back to POS List</a>
                </span>
                <span class="col-xs-12">
                    <a class="btn btn-block btn-info" href="{{ route('pos.pos.create') }}">Back to POS</a>
                </span>
                <div style="clear:both;"></div>
                <div class="col-xs-12" style="background:#F5F5F5; padding:10px;">
                    <p style="font-weight:bold;">
                        Please don't forget to disble the header and footer in browser print settings.
                    </p>
                    <p style="text-transform: capitalize;">
                        <strong>FF:</strong> File &gt; Print Setup &gt; Margin &amp; Header/Footer Make all --blank--
                    </p>
                    <p style="text-transform: capitalize;">
                        <strong>chrome:</strong> Menu &gt; Print &gt; Disable Header/Footer in Option &amp; Set Margins to None
                    </p>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>

        <script type="text/javascript">

            $(window).load(function () {
                window.print();
                return false;
            });

        </script>
    </body>
</html>
