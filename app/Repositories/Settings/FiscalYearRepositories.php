<?php

namespace App\Repositories\Settings;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\FiscalYear;

class FiscalYearRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var FiscalYear
     */
    private $fiscalYear;
    /**
     * CourseRepository constructor.
     * @param fiscalYear $FiscalYear
     */
    public function __construct(FiscalYear $fiscalYear)
    {
        $this->fiscalYear = $fiscalYear;
       
    }


 /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('settings.fiscal_year.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.fiscal_year.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->fiscalYear::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $fiscalYears = $this->fiscalYear::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->fiscalYear::count();
        } else {
            $search = $request->input('search.value');
            $fiscalYears = $this->fiscalYear::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->fiscalYear::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }

        $columns = Helper::getTableProperty();
        $data = array();
        if ($fiscalYears) {
            foreach ($fiscalYears as $key => $fiscalYear) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                if ($fiscalYear->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('settings.fiscal_year.status', [$fiscalYear->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('settings.fiscal_year.status', [$fiscalYear->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
            else:
                $nestedData[$value] = $fiscalYear->$value;
            endif;
        endforeach;
         if ($ced != 0) :
            if ($edit != 0)
                $edit_data = '<a href="' . route('settings.fiscal_year.edit', $fiscalYear->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            else
                $edit_data = '';
           
            if ($delete =! 0)
                $delete_data = '<a delete_route="' . route('settings.fiscal_year.destroy', $fiscalYear->id) . '" delete_id="' . $fiscalYear->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $fiscalYear->id . '"><i class="fa fa-times"></i></a>';
            else
                $delete_data = '';
                $nestedData['action'] = $edit_data . ' ' . $delete_data ;
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
        $result = $this->fiscalYear::find($id);
        return $result;
    }

    public function store($request)
    {
        $fiscalYear = new $this->fiscalYear();
        $fiscalYear->date = helper::mysql_date($request->date);
        $fiscalYear->fiscal_year = helper::mysql_date($request->fiscal_year);
        $fiscalYear->branch_id = $request->branch_id;
        $fiscalYear->status = 'Approved';
        $fiscalYear->created_by = helper::userId();
        $fiscalYear->company_id =  helper::companyId();
        $fiscalYear->save();
        return $fiscalYear;
    }

    public function update($request, $id)
    {
        $fiscalYear = $this->fiscalYear::findOrFail($id);
        $fiscalYear->date = helper::mysql_date($request->date);
        $fiscalYear->fiscal_year = helper::mysql_date($request->fiscal_year);
        $fiscalYear->branch_id = $request->branch_id;
        $fiscalYear->status = 'Approved';
        $fiscalYear->updated_by =  helper::userId();
        $fiscalYear->company_id =  helper::companyId();
        $fiscalYear->save();
        return $fiscalYear;
    }

    public function statusUpdate($id, $status)
    {
        $fiscalYear = $this->fiscalYear::find($id);
        $fiscalYear->status = $status;
        $fiscalYear->save();
        return $fiscalYear;
    }

    public function destroy($id)
    {
        $fiscalYear = $this->fiscalYear::find($id);
        $fiscalYear->delete();
        return true;
    }
}