<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name: </th>
                    <td>{{$details->name ?? ''}}</td>
                </tr>
        
                <tr>
                    <th>Product Category: </th>
                    <td>{{$details->category->name ?? ''}}</td>
                </tr>
        
                <tr>
                    <th>Product Brand: </th>
                    <td>{{$details->brand->name ?? ''}}</td>
                </tr>
        
                <tr>
                    <th>Purchases Price: </th>
                    <td>{{$details->purchases_price ?? ''}}</td>
                </tr>
                <tr>
                    <th>Sales Price: </th>
                    <td>{{$details->sale_price ?? ''}}</td>
                </tr>
               
            </thead>
        </table>
    </div>
</div>

