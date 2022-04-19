<?php

namespace App\Services\InventorySetup;

use App\Repositories\InventorySetup\ProductRepositories;

class ProductService
{

    /**
     * @var ProductRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param ProductRepositories $branchRepositories
     */
    public function __construct(ProductRepositories $systemRepositories)
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
    public function getActiveProduct()
    {
        return $this->systemRepositories->getActiveProduct();
    }
    /**
     * @param $request
     * @return mixed
     */
    public function implodeProduct($request)
    {
        return $this->systemRepositories->implodeProduct($request);
    }
    /**
     * @param $request
     * @return mixed
     */
    public function exploadProduct()
    {
        return $this->systemRepositories->exploadProduct();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function productCode()
    {
        return $this->systemRepositories->productCode();
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
     * @return \App\Models\Product
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Product
     */
    public function details($productId)
    {

        return $this->systemRepositories->details($productId);
    }
   

    /**
     * @param $request
     * @return \App\Models\Product
     */
    public function productStock($productId=null,$branch_id = null,$store_id,$batchNo=null)
    {

        return $this->systemRepositories->productStock($productId,$branch_id,$store_id,$batchNo);
    }


    /**
     * @param $request
     * @param $id
     */
    public function update($request, $id)
    {
        return $this->systemRepositories->update($request, $id);
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