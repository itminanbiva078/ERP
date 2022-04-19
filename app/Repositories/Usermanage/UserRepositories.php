<?php

namespace App\Repositories\Usermanage;
Use App\Helpers\Helper;
use App\Models\RoleAccess;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;

class UserRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var User
     */
    private $user;
    /**
     * CourseRepository constructor.
     * @param user $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        //$this->middleware(function ($request, $next) {
        $this->user_id = 1; //auth()->user()->id;
        //  return $next($request);
        //});
    }
    /**
     * @param $request
     * @return mixed
     */

     
  
   /**
       * @param $request
       * @return mixed
       */
    public function getList($request)
    {
        $columns = Helper::getTableProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('usermanage.user.edit') ? 1 : 0;
        $delete = Helper::roleAccess('usermanage.user.destroy') ? 1 : 0;
        $ced = $edit + $delete ;

        $totalData = $this->user::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = $this->user::select($columns)->with('userRole','company')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->user::count();
        } else {
            $search = $request->input('search.value');
            $users = $this->user::select($columns)->with('userRole','company')->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })
                ->orWhere('email', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                // ->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->user::select($columns)->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }
        $columns = Helper::getTableProperty();
        foreach($users as $key => $eachUser){
            $eachUser->role_id = $eachUser->userRole->name;
            $eachUser->company_id = $eachUser->company->name;
        }
        $data = array();
        if ($users) {
            foreach ($users as $key => $user) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                        if ($user->status == 'Approved') :
                            $status = '<input class="status_row" status_route="' . route('usermanage.user.status', [$user->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        else :
                            $status = '<input  class="status_row" status_route="' . route('usermanage.user.status', [$user->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        endif;
                $nestedData['status'] = $status;
            else:
                if($value == 'role_id'): 
                   $nestedData[$value] =   '<span class="badge badge-sm badge-success"><i class="fa fa-lock"></i>  '.  $user->$value.'</span>';
                elseif($value == 'company_id'): 
                    $nestedData[$value] =   '<span class="badge badge-primary"><i class="fa fa-building"></i> '.$user->$value.'</span>';
                else: 
                    $nestedData[$value] = $user->$value;
                endif;
                
            endif;
        endforeach;
        if ($ced != 0) :
            if ($edit != 0)
                $edit_data = '<a href="' . route('usermanage.user.edit', $user->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            else
                $edit_data = '';
           
            if ($delete != 0)
                $delete_data = '<a delete_route="' . route('usermanage.user.destroy', $user->id) . '" delete_id="' . $user->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $user->id . '"><i class="fa fa-times"></i></a>';
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
        $result = $this->user::find($id);
        return $result;
    }

    public function store($request)
    {
        $user = new $this->user();
        $user->company_id   = $request->company_id;
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->password     = Hash::make($request->password);
        $user->phone        = $request->phone;
        $user->role_id      = $request->role_id;
        $user->status       = $request->status;
        $user->created_by   = Auth::user()->id;
        $user->save();
        if($user):
          $roleAccess = new RoleAccess();
          $roleAccess->user_id = $user->id;
          $roleAccess->role_id = $request->role_id;
          $roleAccess->company_id =$request->company_id;
          $roleAccess->save();
        endif;
        return $user;
    }

    public function update($request, $id)
    {
        $user = $this->user::findOrFail($id);
        $user->company_id   = $request->company_id;
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->phone        = $request->phone;
        if(!empty($request->password)):
         $user->password     = Hash::make($request->password);
        endif;
        $user->role_id      = $request->role_id;
        $user->status       = $request->status;
        $user->updated_by   = Auth::user()->id;
        $user->save();
        if($user){
          $roleAccess =  RoleAccess::where('user_id',$id)->first();
          $roleAccess->user_id = $id;
          $roleAccess->role_id = $request->role_id;
          $roleAccess->company_id =$request->company_id;
          $roleAccess->save();
        }
        return $user;
    }

    public function statusUpdate($id, $status)
    {
        $user = $this->user::find($id);
        $user->status = $status;
        $user->save();
        return $user;
    }

    public function destroy($id)
    {
        $user = $this->user::find($id);
        $user->delete();
        RoleAccess::where('user_id',$id)->delete();
        return true;
    }
}