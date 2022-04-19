<?php

namespace App\Repositories\AccountSetup;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\ChartOfAccount;

class ChartOfAccountRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var ChartOfAccount
     */
    private $chartOfAccount;
    /**
     * ChartOfAccountRepositories constructor.
     * @param chartOfAccount $ChartOfAccount
     */
    public function __construct(ChartOfAccount $chartOfAccount)
    {
        $this->chartOfAccount = $chartOfAccount;
       
    }


    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns, "id");
        $edit = Helper::roleAccess('accountSetup.chartOfAccount.edit') ? 1 : 0;
        $delete = Helper::roleAccess('accountSetup.chartOfAccount.destroy') ? 1 : 0;
        $ced = $edit + $delete;
        $totalData = $this->chartOfAccount::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $chartOfAccounts = $this->chartOfAccount::select($columns)->with('parent','accountType')->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->chartOfAccount::count();
        } else {
            $search = $request->input('search.value');
            $chartOfAccounts = $this->chartOfAccount::select($columns)->with('parent','accountType')->company()->where(function ($q) use ($columns, $search) {
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
            $totalFiltered = $this->chartOfAccount::select($columns)->with('parent','accountType')->company()->where(function ($q) use ($columns, $search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        foreach ($chartOfAccounts as $key => $value) :
            if (!empty($value->parent))
                $value->parent_id = $value->parent->name ?? '';
            if (!empty($value->account_type_id))
                $value->account_type_id = $value->accountType->name ?? '';

            if (!empty($value->is_posted == 1))
                $value->is_posted = 'Posted in Ledger';
            else
                $value->is_posted = 'Parent Account';
        endforeach;

        $columns = Helper::getTableProperty();

        $data = array();
        if ($chartOfAccounts) {
            foreach ($chartOfAccounts as $key => $chartOfAccount) {
                $nestedData['id'] = $key + 1;
                foreach ($columns as $key => $value) :
                    if ($value == 'status') :
                        if ($chartOfAccount->status == 'Approved') :
                            $status = '<input class="status_row" status_route="' . route('accountSetup.chartOfAccount.status', [$chartOfAccount->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        else :
                            $status = '<input  class="status_row" status_route="' . route('accountSetup.chartOfAccount.status', [$chartOfAccount->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        endif;
                        $nestedData['status'] = $status;
                    else :
                        $nestedData[$value] = $chartOfAccount->$value;
                    endif;
                endforeach;

                if ($ced != 0) :
                    if ($edit != 0)
                        $edit_data = '<a href="' . route('accountSetup.chartOfAccount.edit', $chartOfAccount->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';
                    
                    $nestedData['action'] = $edit_data;
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
        $result = $this->chartOfAccount::find($id);

        return $result;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function chartOfAccount($id)
    {
        $result = $this->chartOfAccount::find($id);
        return $result;
    }


    public function store($request)
    {

       

        $chartOfAccount = new $this->chartOfAccount();
        $chartOfAccount->name = $request->name;
        $chartOfAccount->account_type_id = $request->account_type_id;
        $chartOfAccount->account_code = $request->account_code;
        $chartOfAccount->parent_id = $request->parent_id;
        $chartOfAccount->branch_id = $request->branch_id;
        if($request->is_posted == "on"):
            $chartOfAccount->is_posted =1;
        else:
            $chartOfAccount->is_posted =0;
        endif;
        $chartOfAccount->status = 'Approved';
        $chartOfAccount->created_by = helper::userId();
        $chartOfAccount->company_id = helper::companyId();
        $chartOfAccount->save();
        return $chartOfAccount;
    }

    public function update($request, $id)
    {
        $chartOfAccount = $this->chartOfAccount::findOrFail($id);
        $chartOfAccount->name = $request->name;
        $chartOfAccount->account_type_id = $request->account_type_id;
        $chartOfAccount->account_code = $request->account_code;
        $chartOfAccount->parent_id = $request->parent_id;
        $chartOfAccount->branch_id = $request->branch_id;
        $chartOfAccount->status = 'Approved';
        $chartOfAccount->updated_by = helper::userId();
        $chartOfAccount->company_id = helper::companyId();
        $chartOfAccount->save();
        return $chartOfAccount;
    }

    public function statusUpdate($id, $status)
    {
        $chartOfAccount = $this->chartOfAccount::find($id);
        $chartOfAccount->status = $status;
        $chartOfAccount->save();
        return $chartOfAccount;
    }

    public function destroy($id)
    {

        $chartOfAccount = $this->chartOfAccount::find($id);
        $chartOfAccount->delete();
        return true;
    }
}