<?php

namespace App\Repositories\InventorySetup;

use App\Helpers\Helper;

use App\Models\Review;

use DB;

class ProductReviewRepositories
{
    

    private $review;
    
    /**
     * ProductReviewRepositories constructor.
     * @param Review $review
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
      
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $delete = Helper::roleAccess('inventorySetup.productReview.destroy') ? 1 : 0;
        $ced =  $delete ;

        $totalData = $this->review::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $reviews = $this->review::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->review::count();
        } else {
            $search = $request->input('search.value');
            $reviews = $this->review::select($columns)->company()->where(function ($q) use ($columns,$search) {
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
                $totalFiltered = $this->review::select($columns)->company()->where(function ($q) use ($columns,$search) {
                    $q->where('id', 'like', "%{$search}%");
                    foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                    }
                })->count();
        }


       
        $columns = Helper::getTableProperty();
        $data = array();
        if ($reviews) {
            foreach ($reviews as $key => $review) {
             
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                         if ($review->status == 'Approved') :
                            $status = '<input class="status_row" status_route="' . route('inventorySetup.productReview.status', [$review->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        else :
                            $status = '<input  class="status_row" status_route="' . route('inventorySetup.productReview.status', [$review->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                        endif;
                    $nestedData['status'] = $status;
                else:
                    $nestedData[$value] = $review->$value;
                endif;
            endforeach;
            if ($ced != 0) :
               
                if ($delete != 0)
                if(1):
                    $delete_data = '<a delete_route="' . route('inventorySetup.productReview.destroy', $review->id) . '" delete_id="' . $review->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $review->id . '"><i class="fa fa-times"></i></a>';
                else:
                    $delete_data = '';
                endif;
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

       // dd($json_data);
        return $json_data;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->review::find($id);
        return $result;
    }

    public function statusUpdate($id, $status)
    {
        $review = $this->review::find($id);
        $review->status = $status;
        $review->save();
        return $review;
    }


    public function destroy($id)
    {
        $review = $this->review::find($id);
        $review->delete();
        return true;
    }
}
