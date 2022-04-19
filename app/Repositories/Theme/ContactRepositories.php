<?php

namespace App\Repositories\Theme;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;

class ContactRepositories
{
    
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
      
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $delete = Helper::roleAccess('theme.appearance.website.destroy') ? 1 : 0;
        $ced = $delete ;

        $totalData = $this->contact::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $contacts = $this->contact::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->contact::count();
        } else {
            $search = $request->input('search.value');
            $contacts = $this->contact::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->contact::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }
      
        $columns = Helper::getTableProperty();
        $data = array();
        if ($contacts) {
            foreach ($contacts as $key => $contact) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    
                    $nestedData[$value] = $contact->$value;
              
            endforeach;
            if ($ced != 0) :
               
                if ($delete != 0)
                $delete_data = '<a delete_route="' . route('theme.appearance.website.destroy', $contact->id) . '" delete_id="' . $contact->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $contact->id . '"><i class="fa fa-times"></i></a>';
                else
                    $delete_data = '';
                 $nestedData['action'] =  $delete_data;
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
                $result = $this->contact::find($id);
                return $result;
            }
            public function store($request)
            {
                $contact = new $this->contact();
                $contact->name = $request->name;
                $contact->email = $request->email;
                $contact->phone = $request->phone;
                $contact->messege = $request->messege;
                $contact->created_by = helper::userId();
                $contact->company_id = helper::companyId();
                $contact->save();
                return $contact;
            }

            public function statusUpdate($id, $status)
            {
                $contact = $this->contact::find($id);
                $contact->status = $status;
                $contact->save();
                return $contact;
            }
        

            public function destroy($id)
            {
                $contact = $this->contact::find($id);
                $contact->delete();
                return true;
            }

}
