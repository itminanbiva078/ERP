<?php

namespace App\Repositories\Theme;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscribe;

class SubscribeRepositories
{
    
    public function __construct(Subscribe $subscribe)
    {
        $this->subscribe = $subscribe;
      
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $delete = Helper::roleAccess('theme.appearance.subscribe.destroy') ? 1 : 0;
        $ced = $delete ;

        $totalData = $this->subscribe::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $subscribes = $this->subscribe::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->subscribe::count();
        } else {
            $search = $request->input('search.value');
            $subscribes = $this->subscribe::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->subscribe::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }
      
        $columns = Helper::getTableProperty();
        $data = array();
        if ($subscribes) {
            foreach ($subscribes as $key => $subscribe) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    
                    $nestedData[$value] = $subscribe->$value;
              
            endforeach;
            if ($ced != 0) :
               
                if ($delete != 0)
                $delete_data = '<a delete_route="' . route('theme.appearance.subscribe.destroy', $subscribe->id) . '" delete_id="' . $subscribe->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $subscribe->id . '"><i class="fa fa-times"></i></a>';
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
                $result = $this->subscribe::find($id);
                return $result;
            }

            public function store($request)
            {
               // dd($request->all());
                $subscribe = new $this->subscribe();
                $subscribe->email = $request->email;
                $subscribe->created_by = helper::userId();
                $subscribe->company_id = helper::companyId();

                $subscribe->save();
                return $subscribe;
                
            }

            public function statusUpdate($id, $status)
            {
                $subscribe = $this->subscribe::find($id);
                $subscribe->status = $status;
                $subscribe->save();
                return $subscribe;
            }
        

            public function destroy($id)
            {
                $subscribe = $this->subscribe::find($id);
                $subscribe->delete();
                return true;
            }

}
