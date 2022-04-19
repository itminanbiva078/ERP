<div class="row">
    <div class="col-md-12">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th withd="5%!important">#</th>
                <th width="20%!important;">Module</th>
                <th width="20%!important;">Sub-Module</th>
                <th width="60%!important;">Permission</th>
            </tr>
        </thead>
        <tbody>

            @foreach($formProperty as $key1 => $value)
                @php 
                $editInfoValue = App\Models\CompanyResource::where('company_category_id',$company_id)->where('navigation_id',$value->navigation_id)->first();



                @endphp 
         @if(!empty($value->navigation_id))

            <tr>
                <td>{{$key1+2}}</td>
                <td>{{$value->navigation->label ?? ''}}</td>
                <td>{{ucfirst($value->table) ?? ''}}
                    <br>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" @if(in_array($value->navigation_id,$allNavigation)) checked @endif class="submenu submenu_{{$key1}}{{$value->navigation_id}}{{$value->table}}" serial_id="{{$key1}}{{$value->navigation_id}}{{$value->table}}"
                            id="sub_{{$value->navigation_id}}{{$key1}}">
                        <label for="sub_{{$value->navigation_id}}{{$key1}}">
                            Select All
                        </label>
                    </div>
                </td>
                <td>
                    <table class="table table-bordered">
                        @php
                         $inputDetails = json_decode($value->input);
                         if(!empty($editInfoValue->form_input)):
                            $editChildValue = json_decode($editInfoValue->form_input);
                                $allChildName = array();
                            foreach($editChildValue as $k => $ecv): 
                                    array_push($allChildName,$ecv->name);
                            endforeach;
                         endif;
                        @endphp
                        @foreach($inputDetails as $key => $eachInput)
                       @if(!empty($eachInput))
                        <tr>
                            <td>
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox"  @if(in_array($eachInput->name,$allChildName)) checked @endif name="permission[{{$value->navigation_id}}][{{$eachInput->name}}]"  value="{{json_encode($eachInput)}}"  class="child_menu_{{$key1}}{{$value->navigation_id}}{{$value->table}}" id="child_{{$value->table}}{{$key1}}{{$value->navigation_id}}{{$eachInput->name}}{{$key}}">
                                    <label for="child_{{$value->table}}{{$key1}}{{$value->navigation_id}}{{$eachInput->name}}{{$key}}">
                                        {{$eachInput->name ?? ''}}
                                    </label>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </table>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
</div>

