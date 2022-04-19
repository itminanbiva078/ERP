<?php

namespace App\Repositories\AccountSetup;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountType;
use DB;

class AccountTypeRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var AccountType
     */
    private $accountType;
    /**
     * CourseRepository constructor.
     * @param AccountType $accountType
     */
    public function __construct(AccountType $accountType)
    {
        $this->accountType = $accountType;
     
    }

    /**
     * @param $request
     * @return mixed
     */
    
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");  
        $edit = Helper::roleAccess('accountSetup.accountType.edit') ? 1 : 0;
        $delete = Helper::roleAccess('accountSetup.accountType.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->accountType::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $accountTypes = $this->accountType::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->accountType::count();
        } else {
            $search = $request->input('search.value');
            $accountTypes = $this->accountType::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->accountType::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }
        $columns = Helper::getQueryProperty();
        $data = array();
        if ($accountTypes) {
            foreach ($accountTypes as $key => $accountType) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
               
                if ($accountType->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('accountSetup.accountType.status', [$accountType->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('accountSetup.accountType.status', [$accountType->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $accountType->$value;
                endif;
            endforeach;
            if ($ced != 0) :
                if ($edit != 0)
                $edit_data = '<a href="' . route('accountSetup.accountType.edit', $accountType->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                else
                    $edit_data = '';
                if ($delete != 0)
                $delete_data = '<a delete_route="' . route('accountSetup.accountType.destroy', $accountType->id) . '" delete_id="' . $accountType->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $accountType->id . '"><i class="fa fa-times"></i></a>';
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
        $result = $this->accountType::find($id);
        return $result;
    }



      /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        $accountType = new $this->accountType();
        $accountType->name = $request->name;
        $accountType->status = 'Approved';
        $accountType->created_by = helper::userId();
        $accountType->company_id = helper::companyId();
        $accountType->save();
        return $accountType;
    }

    public function update($request, $id)
    {
        $accountType = $this->accountType::findOrFail($id);
        $accountType->name = $request->name;
        $accountType->status = 'Approved';
        $accountType->updated_by = helper::userId();
        $accountType->company_id = helper::companyId();
        $accountType->save();
        return $accountType;
    }

    public function statusUpdate($id, $status)
    {
        $accountType = $this->accountType::find($id);
        $accountType->status = $status;
        $accountType->save();
        return $accountType;
    }

    public function destroy($id)
    {
        $accountType = $this->accountType::find($id);
        $accountType->delete();
        return true;
    }
}