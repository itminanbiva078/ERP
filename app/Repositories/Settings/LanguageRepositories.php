<?php

namespace App\Repositories\Settings;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Language;

class LanguageRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Language
     */
    private $language;
    /**
     * LanguageRepositories constructor.
     * @param language $language
     */
    public function __construct(Language $language)
    {
        $this->language = $language;
       
    }
    /**
     * @param $request
     * @return mixed
     */
    public function getAllList()
    {
        return  $this->language::get();
    }
    /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('settings.language.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.language.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->language::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $languages = $this->language::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->language::count();
        } else {
            $search = $request->input('search.value');
            $languages = $this->language::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
            $totalFiltered = $this->language::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }


        $columns = Helper::getQueryProperty();
        $data = array();
        if ($languages) {
            foreach ($languages as $key => $language) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                if ($language->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('settings.language.status', [$language->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('settings.language.status', [$language->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
                $nestedData['status'] = $status;
            else:
                $nestedData[$value] = $language->$value;
            endif;
        endforeach;
                if ($ced != 0) :
                    if ($edit != 0)
                        $edit_data = '<a href="' . route('settings.language.edit', $language->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';
                    if ($delete != 0)
                        $delete_data = '<a delete_route="' . route('settings.language.destroy', $language->id) . '" delete_id="' . $language->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $language->id . '"><i class="fa fa-times"></i></a>';
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
        $result = $this->language::find($id);
        return $result;
    }

    public function store($request)
    {
        $language = new $this->language();
        $language->name = $request->name;
        $language->flug = $request->flug;
        $language->status = 'Approved';
        $language->created_by = helper::userId();
        $language->company_id = helper::companyId();
        $language->save();
        return $language;
    }

    public function update($request, $id)
    {
        $language = $this->language::findOrFail($id);
        $language->name = $request->name;
        $language->flug = $request->flug;
        $language->status = 'Approved';
        $language->updated_by = helper::userId();
        $language->company_id = helper::companyId();
        $language->save();
        return $language;
    }

    public function statusUpdate($id, $status)
    {
        $language = $this->language::find($id);
        $language->status = $status;
        $language->save();
        return $language;
    }

    public function destroy($id)
    {
        $language = $this->language::find($id);
        $language->delete();
        return true;
    }
}