<?php

namespace App\Services\InventoryTransaction;
use App\Repositories\InventoryTransaction\TransferRepositories;

class TransferService
{

    /**
     * @var TransferRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param TransferRepositories $transferRepositories
     */
    public function __construct(TransferRepositories $systemRepositories)
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
     * @return \App\Models\Transformer
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Transformer
     */
    public function details($id)
    {

        return $this->systemRepositories->details($id);
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