<?php

namespace App\Repositories\AccountSetup;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Bank;
use App\Exports\BanksExports;
use App\Imports\BanksImports;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class BankRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Bank
     */
    private $bank;
    /**
     * CourseRepository constructor.
     * @param bank $bank
     */
    public function __construct(Bank $bank)
    {
        $this->bank = $bank;
       
    }

    /**
     * @param $request
     * @return mixed
     */
    
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");  
        $edit = Helper::roleAccess('accountSetup.bank.edit') ? 1 : 0;
        $delete = Helper::roleAccess('accountSetup.bank.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->bank::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $banks = $this->bank::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->bank::count();
        } else {
            $search = $request->input('search.value');
            $banks = $this->bank::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->bank::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }
        $columns = Helper::getQueryProperty();
        $data = array();
        if ($banks) {
            foreach ($banks as $key => $bank) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
               
                if ($bank->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('accountSetup.bank.status', [$bank->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('accountSetup.bank.status', [$bank->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $bank->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('accountSetup.bank.edit', $bank->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                if ($delete != 0)
                $delete_data = '<a delete_route="' . route('accountSetup.bank.destroy', $bank->id) . '" delete_id="' . $bank->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $bank->id . '"><i class="fa fa-times"></i></a>';
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
        $result = $this->bank::find($id);
        return $result;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function implodeBank(){
        DB::beginTransaction();
        try {
            Excel::import(new BanksImports,request()->file('importFile'));
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
    public function explodeBank()
    {
        return Excel::download(new BanksExports, 'bank-list.xlsx');
    }

      /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        $bank = new $this->bank();
        $bank->bank_name = $request->bank_name;
        $bank->account_name = $request->account_name;
        $bank->account_number = $request->account_number;
        $bank->account_id  = implode(",", $request->account_id ?? '');
        $bank->branch = $request->branch;
        $bank->status = 'Approved';
        $bank->created_by = helper::userId();
        $bank->company_id = helper::companyId();
        $bank->save();
        return $bank;
    }

    public function update($request, $id)
    {
        $bank = $this->bank::findOrFail($id);
        $bank->bank_name = $request->bank_name;
        $bank->account_name = $request->account_name;
        $bank->account_number = $request->account_number;
        $bank->account_id  = implode(",", $request->account_id ?? '');
        $bank->branch = $request->branch;
        $bank->status = 'Approved';
        $bank->updated_by = helper::userId();
        $bank->company_id = helper::companyId();
        $bank->save();
        return $bank;
    }

    public function statusUpdate($id, $status)
    {
        $bank = $this->bank::find($id);
        $bank->status = $status;
        $bank->save();
        return $bank;
    }

    public function destroy($id)
    {
        $bank = $this->bank::find($id);
        $bank->delete();
        return true;
    }
}