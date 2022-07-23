<?php

namespace App\Services\AccountTransaction;
use App\Repositories\AccountTransaction\PaymentVoucherRepositories;

class PaymentVoucherService
{

    /**
     * @var PaymentVoucherRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param PaymentVoucherRepositories $paymentVoucherRepositories
     */
    public function __construct(PaymentVoucherRepositories $systemRepositories)
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
    public function accountApproved($id, $status)
    {
        return $this->systemRepositories->accountApproved($id, $status);
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
    public function store($request)
    {
        return $this->systemRepositories->store($request);
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
     * @return \App\Models\Brand
     */
    public function paymentVoucherDetails($payment_id)
    {
        return $this->systemRepositories->paymentVoucherDetails($payment_id);
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