<?php

namespace App\Services\Dashboard;

use App\Repositories\Dashboard\DashboardRepositories;

class DashboardService
{

    /**
     * @var BookingRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param BookingRepositories $bookingRepositories
     */
    public function __construct(DashboardRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getDashboardReport($date)
    {
        return $this->systemRepositories->getDashboardReport($date);
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
    public function getAvailableRoom($request)
    {
        return $this->systemRepositories->getAvailableRoom($request);
    }
   
   
  
    
    /**
     * @param $request
     * @return mixed
     */
    public function PaymentStatusUpdate($request, $id)
    {
        return $this->systemRepositories->PaymentStatusUpdate($request, $id);
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
    public function bookingDetails($id)
    {

        return $this->systemRepositories->bookingDetails($id);
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
     * @return mixed
     */
    public function approved($request, $id)
    {
        return $this->systemRepositories->approved($request, $id);
    }


    /**
     * @param $request
     * @param $id
     */
    public function floorWiseRoom()
    {
        return $this->systemRepositories->floorWiseRoom();
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