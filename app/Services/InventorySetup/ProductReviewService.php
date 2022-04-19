<?php

namespace App\Services\InventorySetup;
use App\Repositories\InventorySetup\ProductReviewRepositories;

class ProductReviewService
{

    /**
     * @var ProductReviewRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param ProductReviewRepositories $productReviewRepositories
     */
    public function __construct(ProductReviewRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        return $this->systemRepositories->getList($request);
    }
   
    
    /**
     * @param $request
     * @return mixed
     */
    public function statusUpdate($request, $id)
    {
        return $this->systemRepositories->statusUpdate($request, $id);
    }

    public function statusValidation($request)
    {
        return [
            'id'                   => 'required',
            'status'               => 'required',
        ];
    }
    /**
     * @param $request
     * @return \App\Models\Brand
     */
    public function details($id)
    {

        return $this->systemRepositories->details($id);
    }
  
    /**
     * @param $request
     * @param $id
     */
    public function destroy($id)
    {
        return $this->systemRepositories->destroy($id);
    }
}