<?php
namespace App\Services\InventorySetup;
use App\Repositories\InventorySetup\CategoryRepositories;
class CategoryService
{
    /**
     * @var CategoryRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param CategoryRepositories $categoryRepositories
     */
    public function __construct(CategoryRepositories $systemRepositories)
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
     * 
     * @param $request
     * @return mixed
     */
    public function getActiveCategory()
    {
        return $this->systemRepositories->getActiveCategory();
    }
     
    /**
     * 
     * @param $request
     * @return mixed
     */
    public function implodeCategory($request)
    {
        return $this->systemRepositories->implodeCategory($request);
    }
    /**
     * 
     * @param $request
     * @return mixed
     */
    public function explodeCategory()
    {
        return $this->systemRepositories->explodeCategory();
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
     * @return \App\Models\Currency
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Currency
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