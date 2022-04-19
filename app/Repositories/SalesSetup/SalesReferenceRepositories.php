<?php

namespace App\Repositories\SalesSetup;
use App\Helpers\Helper;
use Illuminate\support\Facades\Auth;
use App\Models\Reference;
use App\Exports\ReferencesExports;
use App\Imports\ReferencesImports;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class SalesReferenceRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Reference
     */
    private $reference;
    /**
     * SalesReferenceRepositories constructor.
     * @param reference $reference
     */
    public function __construct(Reference $reference)
    {
        $this->reference = $reference;
       
    }

   
    /**
     * @param $request
     * @return mixed
     */
    
    public function getList($request)
    {
        
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");    
        $edit = Helper::roleAccess('salesSetup.salesReference.edit') ? 1 : 0;
        $delete = Helper::roleAccess('salesSetup.salesReference.destroy') ? 1 : 0;
        $view = Helper::roleAccess('salesSetup.salesReference.show') ? 1 : 0;
        $ced = $edit + $delete + $view;

        $totalData = $this->reference::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $references = $this->reference::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->reference::count();
        } else {
            $search = $request->input('search.value');
            $references = $this->reference::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                // ->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->reference::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }
      

        $columns = Helper::getTableProperty();
        $data = array();
        if ($references) {
            foreach ($references as $key => $reference) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                if ($reference->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('salesSetup.salesReference.status', [$reference->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('salesSetup.salesReference.status', [$reference->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $reference->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('salesSetup.salesReference.edit', $reference->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                if ($delete != 0)
                $delete_data = '<a delete_route="' . route('salesSetup.salesReference.destroy', $reference->id) . '" delete_id="' . $reference->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $reference->id . '"><i class="fa fa-times"></i></a>';
                else
                    $delete_data = '';
                 $nestedData['action'] = $edit_data . ' ' . $delete_data;
            else :
                $nestedData['action'] = '';
            endif;
                $data[] = $nestedData;
           
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return $json_data;
        
    }

    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->reference::find($id);
        return $result;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function implodeSaleReference(){
        DB::beginTransaction();
        try {
            Excel::import(new ReferencesImports,request()->file('importFile'));
            DB::commit();
            // all good
            return 1;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function explodeSaleReference()
    {
        return Excel::download(new ReferencesExports, 'sales-reference-list.xlsx');
    }
    
    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        $reference = new $this->reference();
       
        $reference->name = $request->name;
        $reference->email = $request->email;
        $reference->phone = $request->phone;
        $reference->address = $request->address;
        $reference->status = 'Approved';
        $reference->created_by = helper::userId();
        $reference->company_id = helper::companyId();
        $reference->save();
        return $reference;
    }

    public function update($request, $id)
    {
        $reference = $this->reference::findOrFail($id);
       
        $reference->name = $request->name;
        $reference->email = $request->email;
        $reference->phone = $request->phone;
        $reference->address = $request->address;
        $reference->status = 'Approved';
        $reference->updated_by = helper::userId();
        $reference->company_id = helper::companyId();
        $reference->save();
        return $reference;
    }

    public function statusUpdate($id, $status)
    {
        $reference = $this->reference::find($id);
        $reference->status = $status;
        $reference->save();
        return $reference;
    }

    public function destroy($id)
    {
        $reference = $this->reference::find($id);
        $reference->delete();
        return true;
    }
}