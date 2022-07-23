<?php
namespace App\Helpers;
use Image;
use App\Models\Bank;
use App\Models\BatchNumber;
use App\Models\User;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Floor;
use App\Models\ChartOfAccount;
use App\Models\Company;
use App\Models\CompanyCategory;
use App\Models\CompanyResource;
use App\Models\GeneralLedger;
use App\Models\GeneralSetup;
use App\Models\GeneralTable;
use App\Models\Navigation;
use App\Models\OpeningBalance;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\PurchaseRequisition;
use App\Models\Purchases;
use App\Models\SalesQuatation;
use App\Models\ServiceQuatation;
use App\Models\PurchasesOrder;
use App\Models\Review;
use App\Models\SaleReturn;
use App\Models\Sales;
use App\Models\ServiceCategory;
use App\Models\Stock;
use App\Models\StockSummary;
use App\Models\Store;
use App\Models\Supplier;
use Illuminate\Support\Facades\Route;
use App\Rules\PhoneNumberValidationRules;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Helper
{

    /**
     * This method is for get current user role name
     * @return string
     */

    public static function getUserRole()
    {
        $roleInfo =  User::select('user_roles.role_name')->join('role_accesses', 'users.id', 'role_accesses.user_id')
            ->join('user_roles', 'user_roles.id', 'role_accesses.role_id')
            ->where('users.id', self::userId())->first();

        return $roleInfo->role_name ?? '';
    }
    /**
     * This method is for get current  user role access list
     * @return string
     */
    public static function getRoleAccessNavigation()
    {

        $roleInfo =  User::select('user_roles.navigation_id')
            ->join('role_accesses', 'users.id', 'role_accesses.user_id')
            ->join('user_roles', 'user_roles.id', 'role_accesses.role_id')
            ->where('users.id', self::userId())->first();
        return $roleInfo->navigation_id ?? '';
    }



    public static function productBatch($batchNo){

        $batchExits = BatchNumber::where("name",$batchNo)->company()->first();
        if(!empty($batchExits)){
         return   $batchExits->id;
        }else{
         $batchInfo =    new BatchNumber();
         $batchInfo->name = $batchNo;
         $batchInfo->company_id = helper::companyId();
         $batchInfo->save();
         return $batchInfo->id;
        }

    }

    /**
     * This method is for get current admin user details
     * @return object
     */
    public static function getRoleAccessParent()
    {
        $roleInfo =  User::select('user_roles.parent_id')
            ->join('role_accesses', 'users.id', 'role_accesses.user_id')
            ->join('user_roles', 'user_roles.id', 'role_accesses.role_id')
            ->where('users.id', self::userId())->first();
        return $roleInfo->parent_id ?? '';
    }


    public static function getColumnProperty($table,$columns){
        $tableProperty = DB::table("company_resources")->select("form_input")->where('table',$table)->first();
        $tableArray = json_decode($tableProperty->form_input);
        $input=array();
        foreach($tableArray as $key => $eachArray):
                if(in_array($eachArray->name,$columns)){

                    array_push($input,$eachArray);
                }
        endforeach;
       return $input;
    }
    public static function getFormInputByRoute($customRoute = null)
    {
        if (is_null($customRoute)) :
            $navigation_id =  self::getCurrentNavigationId(Route::currentRouteName());
        else :
            $navigation_id =  self::getCurrentNavigationId($customRoute);
        endif;
        return self::getFormInput($navigation_id);
    }
    /**
     * This method is for get current admin user details
     * @return object
     */
    public static function getMenuParent(string $route)
    {
        $routeChildInfo =  Navigation::where('route', $route)->first();
        if (!empty($routeChildInfo))
            $routeSubMenuInfo =  Navigation::where('id', $routeChildInfo->parent_id)->first();
        if (!empty($routeSubMenuInfo))
            $routeParentInfo =  Navigation::where('id', $routeSubMenuInfo->parent_id)->first();
        if (!empty($routeParentInfo))
            return str_replace(" ", "_", $routeParentInfo->label);
    }

    public static function getFormInput_old($navigation_id)
    {
        $formInput = CompanyResource::where('navigation_id', $navigation_id)->where('company_category_id',self::companyId())->first();
        if(!empty($formInput)):
            return json_decode($formInput->form_input);
        else:
            return false;
        endif;


    }

    public static function getFormInput($navigation_id)
    {
       $formInput = CompanyResource::where('navigation_id', $navigation_id)->where('company_category_id',self::companyId())->first();

        $filterFrom = array();
        if(!empty($formInput->form_input)){

            $formStructures = json_decode($formInput->form_input);
        }else{
            $formStructures = array();
        }
        if(!empty($formStructures)):
            foreach($formStructures as $key => $eachStructure):
                if($eachStructure->inputShow == true):
                    if($eachStructure->name == 'branch_id' || $eachStructure->name == 'from_branch_id' || $eachStructure->name == 'to_branch_id'):

                        if(self::isBranchEnable() && self::branchIsActive()):

                            array_push($filterFrom, $eachStructure);
                            endif;
                    elseif($eachStructure->name == 'store_id' || $eachStructure->name == 'from_store_id' || $eachStructure->name == 'to_store_id'):
                        if(self::isStoreEnable() && self::storeIsActive()):
                            array_push($filterFrom, $eachStructure);
                        endif;
                    else:
                        array_push($filterFrom, $eachStructure);
                    endif;
                endif;

            endforeach;
        endif;
       return $filterFrom ?? true;
    }

    public static function getFormInputForQuery($navigation_id)
    {
       $formInput = CompanyResource::where('navigation_id', $navigation_id)->where('company_category_id',self::companyId())->first();

        $filterFrom = array();
        if(!empty($formInput->form_input)){
            $formStructures = json_decode($formInput->form_input);
        }else{
            $formStructures = array();
        }
        if(!empty($formStructures)):
            foreach($formStructures as $key => $eachStructure):

                    if($eachStructure->name == 'branch_id' || $eachStructure->name == 'from_branch_id' || $eachStructure->name == 'to_branch_id'):
                            if(self::isBranchEnable() && self::branchIsActive()):
                            array_push($filterFrom, $eachStructure);
                            endif;
                    elseif($eachStructure->name == 'store_id' || $eachStructure->name == 'from_store_id' || $eachStructure->name == 'to_store_id'):
                        if(self::isStoreEnable() && self::storeIsActive()):
                            array_push($filterFrom, $eachStructure);
                        endif;
                    else:
                        array_push($filterFrom, $eachStructure);
                    endif;
            endforeach;
        endif;
       return $filterFrom ?? true;
    }



    public static function getActiveInput($customeRoute = null)
    {
        $formInput = self::getFormInput(self::getCurrentNavigationId($customeRoute));
        $property = array();
        foreach ($formInput as $key => $eachInput) :
            if ($eachInput->inputShow == true) :
            array_push($property, $eachInput->name);
            endif;
        endforeach;
        return $property;

    }



    public static function getQueryPropertyForDataTable($customeRoute = null)
    {
        $formInput = self::getFormInputForQuery(self::getCurrentNavigationId($customeRoute));
      
        $property = array();
        foreach ($formInput as $key => $eachInput) :
            if ($eachInput->tableshow == true) :
                if($eachInput->name == 'branch_id'):
                    if(self::isBranchEnable() && self::branchIsActive()):
                        array_push($property, $eachInput->name);
                    endif;
                elseif($eachInput->name == 'store_id'):
                    if(self::isStoreEnable() && self::storeIsActive()):
                        array_push($property, $eachInput->name);
                    endif;
                else:
                    array_push($property, $eachInput->name);
                endif;
            endif;
        endforeach;
        return $property;
    }

    public static function getQueryProperty($customeRoute = null)
    {
        $formInput = self::getFormInputForQuery(self::getCurrentNavigationId($customeRoute));
        $property = array();
        foreach ($formInput as $key => $eachInput) :

            if($eachInput->name == 'branch_id'):
                if(self::isBranchEnable() && self::branchIsActive()):
                array_push($property, $eachInput->name);
                endif;
        elseif($eachInput->name == 'store_id'):
            if(self::isStoreEnable() && self::storeIsActive()):
                array_push($property, $eachInput->name);
            endif;
        else:
            array_push($property, $eachInput->name);
        endif;
        endforeach;
        return $property;
    }


    public static function getTableProperty($customeRoute = null)
    {
        $formInput = self::getFormInputForQuery(self::getCurrentNavigationId($customeRoute));
        $property = array();
        foreach ($formInput as $key => $eachInput) :
            if ($eachInput->tableshow == true) :
                if($eachInput->name == 'branch_id'):
                    if(self::isBranchEnable() && self::branchIsActive()):
                        array_push($property, $eachInput->label);
                    endif;
                elseif($eachInput->name == 'store_id'):
                    if(self::isStoreEnable() && self::storeIsActive()):
                        array_push($property, $eachInput->label);
                    endif;
                else:
                    array_push($property, $eachInput->label);
                endif;
            endif;
        endforeach;
        return $property;
    }


    public static function getVoucher($relationShip){

        if(!empty($relationShip->purchase)):
            $voucherInfo = '<a href="' . route('inventoryTransaction.purchases.show', $relationShip->purchase->id) . '" show_id="' . $relationShip->purchase->id . '" title="Purchases Voucher Details" class="btn btn-xs btn-default"><i class="fa fa-search-plus"></i> '.$relationShip->purchase->voucher_no.'</a>';
        elseif($relationShip->sale):
        $voucherInfo = '<a href="' . route('salesTransaction.sales.show', $relationShip->sale->id) . '" show_id="' . $relationShip->sale->id . '" title="Sale Voucher Details" class="btn btn-xs btn-default "><i class="fa fa-search-plus"></i> '.$relationShip->sale->voucher_no.'</a>';
       elseif($relationShip->paymentVoucher):
        $voucherInfo = '<a href="' . route('accountTransaction.paymentVoucher.show', $relationShip->paymentVoucher->id) . '" show_id="' . $relationShip->paymentVoucher->id . '" title="Payment Voucher Details" class="btn btn-xs btn-default  "><i class="fa fa-search-plus"></i> '.$relationShip->paymentVoucher->voucher_no.'</a>';
        
       elseif($relationShip->receiveVoucher):
        $voucherInfo = '<a href="' . route('accountTransaction.receiveVoucher.show', $relationShip->receiveVoucher->id) . '" show_id="' . $relationShip->receiveVoucher->id . '" title="Receive Voucher Details" class="btn btn-xs btn-default  "><i class="fa fa-search-plus"></i> '.$relationShip->receiveVoucher->voucher_no.'</a>';
        
       elseif($relationShip->journalVoucher):
        $voucherInfo = '<a href="' . route('accountTransaction.journalVoucher.show', $relationShip->journalVoucher->id) . '" show_id="' . $relationShip->journalVoucher->id . '" title="Journal Voucher Details" class="btn btn-xs btn-default  "><i class="fa fa-search-plus"></i> '.$relationShip->journalVoucher->voucher_no.'</a>';
       elseif($relationShip->flatSale):
        $voucherInfo = '<a href="' . route('projectTransaction.flatSale.show', $relationShip->flatSale->id) . '" show_id="' . $relationShip->flatSale->id . '" title="Flat Sale Voucher Details" class="btn btn-xs btn-default  "><i class="fa fa-search-plus"></i> '.$relationShip->flatSale->voucher_no.'</a>';
        
       elseif($relationShip->materialIssue):
        $voucherInfo = '<a href="' . route('salesTransaction.materialIssue.show', $relationShip->materialIssue->id) . '" show_id="' . $relationShip->materialIssue->id . '" title="Flat Sale Voucher Details" class="btn btn-xs btn-default  "><i class="fa fa-search-plus"></i> '.$relationShip->materialIssue->voucher_no.'</a>';
        
       elseif($relationShip->inventoryAdjust):
        $voucherInfo = '<a href="' . route('inventoryTransaction.inventoryAdjustment.show', $relationShip->inventoryAdjust->id) . '" show_id="' . $relationShip->inventoryAdjust->id . '" title="Flat Sale Voucher Details" class="btn btn-xs btn-default  "><i class="fa fa-search-plus"></i> '.$relationShip->inventoryAdjust->voucher_no.'</a>';
        
       else: 
        $voucherInfo='N/A';
       endif;
        return $voucherInfo;
        

    }

    public static function getAvailableRoom($request)
    {
        $dateRange = explode("-",$request->daterange);
        $from_date = date('Y-m-d',strtotime($dateRange[0]));
        $to_date = date('Y-m-d',strtotime($dateRange[1]));
        $adult = $request->adult ?? 0;
        $child = $request->children ?? 0;
        $totalPerson = $adult+$child;
        $totalPerson = $totalPerson ?? 1;

        $sql = "select
        p.id
        from
            products p
            LEFT JOIN product_images as pi on pi.product_id = p.id
            LEFT JOIN product_details as pd on pd.product_id = p.id
            LEFT JOIN
            ( select
                    b.room_id
                    from
                    booking_details b,
                    ( select @parmStartDate := '$from_date',
                        @parmEndDate := '$to_date'  ) sqlvars
                    where
                        b.exit_date >= @parmStartDate
                    AND b.entry_date <= @parmEndDate
                    AND (  timestampdiff( day, b.entry_date, @parmEndDate )
                        * timestampdiff( day, @parmStartDate, b.exit_date  )) > 0 ) Occupied
            ON p.id = Occupied.room_id
        where pd.number_of_room >= '$totalPerson' and
        Occupied.room_id IS NULL AND p.type_id='Rooms';";
        $result =  DB::SELECT($sql);
        $allRoomId=array();
        foreach($result as $key => $value):
            array_push($allRoomId,$value->id);
        endforeach;
        $result = Product::with('productDetails','productImages')->whereIn('id', $allRoomId)->get();
         return $result;


    }


    public static function getVoucherBy($relationShip){



      //  dd($relationShip);


        if(!empty($relationShip->purchase->supplier) && $relationShip->form_id == 4):
            $voucherBy = $relationShip->purchase->supplier->name ?? '';
        elseif($relationShip->sale  && $relationShip->form_id == 5):
            $voucherBy = $relationShip->sale->customer->name ?? '';
        elseif($relationShip->paymentVoucher  && $relationShip->form_id == 2):
              /*inside nested condition start*/
                    if($relationShip->paymentVoucher->customer){
                        $voucherBy = $relationShip->paymentVoucher->name ?? '';
                    }else{
                        $voucherBy = $relationShip->paymentVoucher->supplier->name ?? '';
                    }
              /*inside nested condition start*/
        elseif($relationShip->receiveVoucher  && $relationShip->form_id == 3):
            /*inside nested condition start*/
                if($relationShip->receiveVoucher->customer){
                    $voucherBy = $relationShip->receiveVoucher->name ?? '';
                }else{
                    $voucherBy = $relationShip->receiveVoucher->supplier->name ?? '';
                }
          /*inside nested condition start*/
       elseif($relationShip->journalVoucher  && $relationShip->form_id == 1):
        $voucherBy='N/A';
        else:
        $voucherBy='N/A';
       endif;
        return $voucherBy;


    }

    public static function getOpeningBalance($account_id,$fromDate){
      $openingTableOpeningBalance =   OpeningBalance::select(DB::raw('sum(IFNULL(debit,0)+IFNULL(credit,0)) as opening'))->where('company_id',self::companyId())->where('account_id',$account_id)->first();
      $openingBalance = GeneralLedger::select(DB::raw('sum(IFNULL(debit,0)-IFNULL(credit,0)) as openingFromdate'))->where('date','<',$fromDate)->where('account_id',$account_id)->company()->first();
      $totalOpenignBalnace = $openingTableOpeningBalance->opening + $openingBalance->openingFromdate;
      return $totalOpenignBalnace ?? 0;
    }

    public static function isErrorStore($request,$currentRoute=null)
    {
        $formInput = self::getFormInput(self::getCurrentNavigationId($currentRoute));
        foreach ($formInput as $key => $value) :
            if (!empty($value->validation)) :
                if ($value->name == 'phone' && $value->unique == true) :
                    $formInfo[$value->name] = ['required', 'unique:' . $value->table . ',phone', 'regex:/(^(01))[3-9]{1}(\d){8}$/', new PhoneNumberValidationRules($request)];
                elseif ($value->name == 'phone' && $value->unique != true) :
                    $formInfo[$value->name] = ['required', 'regex:/(^(01))[3-9]{1}(\d){8}$/', new PhoneNumberValidationRules($request)];
                else :
                    $formInfo[$value->name] = $value->validation;
                endif;
            endif;
        endforeach;
        return $formInfo;
    }

    public static function isErrorUpdate($request, $id)
    {
        $formInput = self::getFormInput(self::getCurrentNavigationId());

        foreach ($formInput as $key => $value) :
            if (!empty($value->validation)) :
                if ($value->name == 'phone' && $value->unique == true) :
                    $formInfo[$value->name] = ['required', 'unique:' . $value->table . ',phone,' . $id, 'regex:/(^(01))[3-9]{1}(\d){8}$/', new PhoneNumberValidationRules($request)];
                elseif ($value->name  == 'phone' && $value->unique != true) :
                    $formInfo[$value->name] = ['required', 'regex:/(^(01))[3-9]{1}(\d){8}$/', new PhoneNumberValidationRules($request)];
                elseif (!empty($value->unique) && $value->unique  == true && $value->name != 'phone') :
                    $formInfo[$value->name] = $value->validation . ',' . $id;
                else :
                    $formInfo[$value->name] = $value->validation;
                endif;
            endif;
        endforeach;
        return $formInfo;
    }

    /**
     * This method is for get current admin user details
     * @return object
     */
    public static function getCurrentNavigationId($customRoute = null)
    {
        if (is_null($customRoute)) {
            $routeChildInfo =  Navigation::where('route', Route::currentRouteName())->first();

        } else {
            $routeChildInfo =  Navigation::where('route', $customRoute)->first();
        }

       return $routeChildInfo->parent_id ?? 0;
    }



    /**
     * This method is for get current admin user details
     * @return object
     */
    public static function getRoleRootList()
    {
        $roleInfo =  Navigation::select('parent_id')->whereIn('id', explode(",", self::getRoleAccessParent()))->distinct()->get();
        $rootList = array();
        foreach ($roleInfo as $key => $eachRole) :
            array_push($rootList, $eachRole->parent_id);
        endforeach;
        return $rootList ?? '';
    }



    public static function companyInfo()
    {
       $companyInfo = Company::where('company_id',self::companyId())->first();
       return $companyInfo;
    }


    /**
     * This method is for get current admin user details
     * @return object
     */
    public static function getUserNavigations()
    {
        $allNavigation =  Navigation::whereIn('id', explode(",", self::getRoleAccessNavigation()))->get();
        return $allNavigation ?? '';
    }


    /**
     * This method is for get current admin user details
     * @return object
     */
    public static function roleAccess(string $route)
    {
        $allNavigation = self::getUserNavigations();
        $accessExits = $allNavigation->where('route', $route);
        if (count($accessExits) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This method is for get current admin user details
     * @return object
     */
    public static function getRoleAccessBranch()
    {
        $roleInfo =  User::select('user_roles.branch_id')
            ->join('role_accesses', 'users.id', 'role_accesses.user_id')
            ->join('user_roles', 'user_roles.id', 'role_accesses.role_id')
            ->where('users.id', self::userId())->first();

        return $roleInfo->branch_id ?? '';
    }

    /**
     * This method is for get current admin user details
     * @return object
     */
    public static function userBranch()
    {
        $branchList =  Branch::whereIn('id', explode(",", self::getRoleAccessBranch()))->get();
        return $branchList ?? '';
    }

    /**
     * This method is for get current admin user details
     * @return object
     */
    public static function userDetails()
    {
        if (auth()->check()) {
            return auth()->user();
        }
    }

    /**
     *  This method will provide curret user id
     * @return int id
     */
    public static function userId()
    {
        if (isset(self::userDetails()['id'])) {
            return self::userDetails()['id'];
        } else {
            return 0;
        }
    }

    /**
     *  This method will provide curret username
     * @return string username
     */
    public static function userFullname()
    {
        return self::userDetails()['name'];
    }
    /**
     *  This method will provide curret user email
     * @return string email
     */
    public static function userEmail()
    {
        return self::userDetails()['email'];
    }
    public static function companyId()
    {
        return self::userDetails()['company_id'];
    }



    public static function checkDateType($userDate){

        if(preg_match("/^[0-9]{1,2}\\/[0-9]{2}\\/[0-9]{4}$/", $userDate)
        OR preg_match("/^[0-9]{1,2}\\/[0-9]{2}\\/[0-9]{4} [0-9]{2}\\:[0-9]{2}\\:[0-9]{2}$/", $userDate)) {
            return true;
        }else {
           return false;
        }

    }



    public static function get_php_date($userDate=null){
        //get date format
        $dateFormat =   self::get_php_date_format();
        if(!empty($userDate) && !empty($dateFormat)){
            return date($dateFormat,strtotime($userDate));
        }else if(empty($userDate) && !empty($dateFormat)){
            return date($dateFormat,strtotime(date('Y-m-d')));
        }else if(!empty($userDate) && empty($dateFormat)){
            return date('Y-m-d',strtotime($userDate));
        }else{
            return date('Y-m-d');
        }


    }

    public static function mysql_date($userDate=null){

            if(!empty($userDate)):
                return date('Y-m-d',strtotime($userDate));
            else:
                return date('Y-m-d');
            endif;

    }


    public static function get_js_date($userDate=null){
            //get date format
        $dateFormat =   self::get_js_date_format();
        if(!empty($userDate) && !empty($dateFormat)){
            return date($dateFormat,strtotime($userDate));
        }else if(empty($userDate) && !empty($dateFormat)){
            return date($dateFormat,strtotime(date('Y-m-d')));
        }else if(!empty($userDate) && empty($dateFormat)){
            return date('Y-m-d',strtotime($userDate));
        }else{
            return date('Y-m-d');
        }
    }

    public static function get_php_date_format(){
            //get date format
           $dateSetupFormat = self::geSetupValue('dateformat');
           if(!empty($dateSetupFormat)):
            $dateFormat = '';
            if($dateSetupFormat == 'DD-MM-YYYY'):
                $dateFormat = 'd-m-Y';
            elseif ($dateSetupFormat == 'YYYY-MM-DD'):
                $dateFormat = 'Y-m-d';
            elseif($dateSetupFormat == 'DD.MM.YYYY'):
                $dateFormat = 'd.m.Y';
            elseif($dateSetupFormat == 'YYYY.MM.DD'):
                $dateFormat = 'Y.m.d';
            elseif($dateSetupFormat == 'DD,MM,YYYY'):
                $dateFormat = 'd,m,Y';
            elseif($dateSetupFormat == 'YYYY,MM,DD'):
                $dateFormat = 'Y,m,d';
            elseif($dateSetupFormat == 'MmmDDYYYY'):
                $dateFormat = 'F j, Y';
            else:
                $dateFormat = 'Y-m-d';
            endif;

            return $dateFormat;
        else:
            return 'Y-m-d';
        endif;

    }
    public static function get_js_date_format(){
            //get date format
           $dateSetupFormat = self::geSetupValue('dateformat');
           if(!empty($dateSetupFormat)):
            $dateFormat = '';
            if($dateSetupFormat == 'DD-MM-YYYY'):
                $dateFormat = 'DD-MM-YYYY';
            elseif ($dateSetupFormat == 'YYYY-MM-DD'):
                $dateFormat = 'YYYY-MM-DD';
            elseif($dateSetupFormat == 'DD.MM.YYYY'):
                $dateFormat = 'DD.MM.YYYY';
            elseif($dateSetupFormat == 'YYYY.MM.DD'):
                $dateFormat = 'YYYY.MM.DD';
            elseif($dateSetupFormat == 'DD,MM,YYYY'):
                $dateFormat = 'DD,MM,YYYY';
            elseif($dateSetupFormat == 'YYYY,MM,DD'):
                $dateFormat = 'YYYY,MM,DD';
            elseif($dateSetupFormat == 'MmmDDYYYY'):
                $dateFormat = 'MMMM D, YYYY';
            else:
                $dateFormat = 'YYYY-MM-DD';
            endif;

            return $dateFormat;
        else:
            return 'YYYY-MM-DD';
        endif;

    }
    public static function isPurchasesApprovalAuto(){
      $approbalValue =   self::geSetupValue("inventory_approval");
      if($approbalValue == "Auto Approval"){
        return true;
      }else{
          return false;
      }

    }


    public static function isMrrApprovalAuto(){
      $approbalValue =   self::geSetupValue("mrr_approval");
      if($approbalValue == "Auto Approval"){
        return true;
      }else{
          return false;
      }

    }


    public static function isPosAutoApprobal(){
      $approbalValue =   self::geSetupValue("pos_approval");
      if($approbalValue == "Auto Approval"){
        return true;
      }else{
          return false;
      }

    }
    public static function posDepositAccount(){
      $approbalValue = 7;//  self::geSetupValue("pos_approval");
      return $approbalValue;

    //   if($approbalValue == "Auto Approval"){
    //       return true;
    //   }else{
    //       return false;
    //   }

    }



    public static function getDefaultBranch(){
       $defaultBranch =  Branch::where('company_id',self::companyId())->where('is_default',"Yes")->first();
      return $defaultBranch->id ?? 0;
    }


    public static function getDefaultStore(){
       $defaultStore =  Store::where('company_id',self::companyId())->where('is_default',"Yes")->first();
      return $defaultStore->id ?? 0;
    }

    public static function isDeliveryChallanApprovalAuto(){
      $approbalValue =   self::geSetupValue("challan_approval");
      if($approbalValue == "Auto Approval"){
        return true;
      }else{
          return false;
      }

    }
    public static function isSaleApprovalAuto(){
      $approbalValue =   self::geSetupValue("sales_approval");
      if($approbalValue == "Auto Approval"){
        return true;
      }else{
          return false;
      }

    }


    public static function getSalesReturnAmount($sale_id){

       $totalAmount =   SaleReturn::where('sale_id',$sale_id)->company()->groupBy('sale_id')->selectRaw('*, sum(grand_total) as totalAmount')->first();
       return $totalAmount->totalAmount ?? 0;
    }


    public static function getDefaultBatch(){
        $defaultBatch ='BH-00'.helper::companyId();
        return self::productBatch($defaultBatch);
    }


    public static function mrrIsActive(){
      $approbalValue =   self::geSetupValue("purchases_mrr");
      if($approbalValue == "Yes"){
        return true;
      }else{
          return false;
      }

    }



    public static function isDeliveryChallanActive(){
      $approbalValue =   self::geSetupValue("delivery_challan");
      if($approbalValue == "Yes"){
        return true;
      }else{
          return false;
      }

    }




    public static function geSetupValue($columnName = null)
    {
        if(is_null(self::companyId())):
            $generalInfo = GeneralSetup::first();
        else:
            $generalInfo = GeneralSetup::where('company_id',self::companyId())->first();
        endif;

        return $generalInfo->$columnName ?? '';
    }

    /**
     *  This method will provide curret user email
     * @return string email
     */
    public static function generateInvoiceId($prefix_name, $table,$length=null)
    {
        $prefix =  self::geSetupValue($prefix_name);
        if(is_null($length)){
            $invoiceLength =  self::geSetupValue('voucher_length');
        }else{
            $invoiceLength = $length;
            $prefix = $prefix_name;
        }
        $lastInvoiceId = DB::table($table)->where('company_id',self::companyId())->orderBy('id', 'DESC')->first();
        $lastInvoiceId = $lastInvoiceId->id ?? 0;
        $voucherId =  $prefix . str_pad($lastInvoiceId +1, $invoiceLength, "0", STR_PAD_LEFT);
        return $voucherId;
    }

    public static function getRow($table,$column,$value,$pickValue){
      $result = DB::table($table)->where($column,$value)->where('company_id',self::companyId())->first();
      if($result):
        return $result->$pickValue;
      else:
        return true;
      endif;
    }

    public static function getActiveBatch($productId=null){
        $batch =  StockSummary::with("batch")
        ->when($productId, function ($query) use ($productId) {
            $query->where('product_id', $productId);
            })
        ->company()
        ->groupBy("batch_no")
        ->havingRaw('quantity > 0')->get();
        return $batch;

    }

    public static function getActiveBatchStock($productId=null,$batchNo=null){
        $batch =  StockSummary::with("batch")
        ->when($productId, function ($query) use ($productId) {
            $query->where('product_id', $productId);
            })
        ->when($batchNo, function ($query) use ($batchNo) {
            $query->where('batch_no', $batchNo);
            })
        ->company()
        ->havingRaw('quantity > 0')->first();
        return $batch->quantity ?? 0;

    }

    public static function getProductStock($productId=null,$batchNo=null){

       $mrrIsActive =   self::getGeneralData("purchases_mrr");
        if($mrrIsActive == "Yes"):
            $batchNo = $batchNo;
        else:
            $batchNo = null;
        endif;
       $quantity = StockSummary::select("quantity")
       ->when($productId, function ($query) use ($productId) {
        $query->where('product_id', $productId);
        })
       ->when($batchNo, function ($query) use ($batchNo) {
        $query->where('batch_no', $batchNo);
        })
       ->company()
       ->first();
       return $quantity->quantity ?? 0;

    }

 public static function getLedgerType($type){
    if($type == 'in'):
        $ltype = 'Purchases';
    elseif($type == 'tin'):
        $ltype = 'Transfer Received';
    elseif($type == 'rin'):
        $ltype = 'Sale Return';
    elseif($type == 'out'):
        $ltype = 'Sales';
    elseif($type == 'tout'):
        $ltype = 'Transfer Out';
    elseif($type == 'rout'):
        $ltype = 'Purchases Return';
    elseif($type == 'lout'):
        $ltype = 'Sales Loan';
    elseif($type == 'lin'):
        $ltype = 'Sales Loan Return';
    else:
        $ltype = 'N/A';
    endif;
    return $ltype;
 }

    public static function productAvg($product_id,$batch_id=null){

        if(!empty($batch_id)):
            $productAvgPrice =  Stock::selectRaw('sum(total_price)/sum(quantity) as avgPrice')->company()->where('type','in')->where('product_id',$product_id)->where('batch_no',$batch_id)->first();
        else:
            $productAvgPrice =  Stock::selectRaw('sum(total_price)/sum(quantity) as avgPrice')->company()->where('type','in')->where('product_id',$product_id)->first();
        endif;
        return $productAvgPrice->avgPrice ?? 0;
    }

    public static function getLedgerHead()
    {
        $ledgerParent = ChartOfAccount::select('parent_id')->where('is_posted', 1)->distinct()->get();
      
        $ledgerAccount = array();
        foreach ($ledgerParent as $key => $value) {
            $index['parent'] = ChartOfAccount::select('name', 'id')->where('id', $value->parent_id)->first();
            $index['parentChild'] = ChartOfAccount::select('name', 'id')->where('parent_id', $value->parent_id)->where('is_posted', 1)->get();
           
            $ledgerAccount[] = $index;
        }
        return $ledgerAccount;
    }

    public static function getLedgerHeadTypWise($type)
    {
        $ledgerParent = ChartOfAccount::select('parent_id')->where('is_posted', 1)->distinct()->get();
        $ledgerAccount = array();
        foreach ($ledgerParent as $key => $value) {
            $index['parent'] = ChartOfAccount::select('name', 'id')->where('id', $value->parent_id)->first();
            $index['parentChild'] = ChartOfAccount::select('name', 'id')->where('parent_id', $value->parent_id)->where('account_type_id',$type)->where('is_posted', 1)->get();
           
            $ledgerAccount[] = $index;
        }
        return $ledgerAccount;
    }


    public static function getPaymentLedgerHead()
    {
        
        $parentId=array(2,8);
        $ledgerParent = ChartOfAccount::select('parent_id')->whereIn('parent_id',$parentId)->where('is_posted', 1)->distinct()->get();
        $notInValue=array(12,13,14,15,16,3);
        $ledgerAccount = array();
        foreach ($ledgerParent as $key => $value) {
            $index['parent'] = ChartOfAccount::select('name', 'id')->where('id', $value->parent_id)->first();
            $index['parentChild'] = ChartOfAccount::select('name', 'id')->whereNotIn('id',$notInValue)->where('parent_id', $value->parent_id)->where('is_posted', 1)->get();
            $ledgerAccount[] = $index;
        }
        return $ledgerAccount;
    }


    public static function priceCalType($price){
       $calculateType = self::geSetupValue('price_calculate_type');
       $afterTypeCal = 0;
       if($calculateType == 'Round'){
        $afterTypeCal = round($price);
       }else{
        $afterTypeCal = round($price,2);
       }
       return $afterTypeCal;
    }

    public static function pricePrint($price)
    {
        $separateType = self::geSetupValue('thousand_separate');
      return number_format(helper::priceCalType($price), 2, '.', $separateType);  // Outputs -> 105.00

    }

    public static function getColspan($activeColumn,$extraParam=null)
    {

        if(count($activeColumn) == 7){
            echo 5+$extraParam;
        }else if(count($activeColumn) == 6){
            echo 4+$extraParam;

        }else if(count($activeColumn) == 5){
            echo 3+$extraParam;

        }else if(count($activeColumn) == 4){
            echo 2+$extraParam;

        }else if(count($activeColumn) == 3){
            echo 1+$extraParam;
        }else{
            echo 1+$extraParam;
        }

    }


    public static function getGeneralData($columnName){
            $generalInfo = GeneralSetup::where('company_id',self::companyId())->first();
            $columnValue = $generalInfo->$columnName ?? '';
            return $columnValue;
    }

    public static function getCompanyData($columnName){
            $companyInfo = Company::where('company_id',self::companyId())->first();
            $columnValue = $companyInfo->$columnName ?? '';
            return $columnValue;
    }


    public static function isBranchEnable(){
        $companyCategory =   CompanyCategory::where('id',self::companyId())->first();

        if($companyCategory->is_branch == 1){
          return true;
        }else{
            return false;
        }

      }
      public static function isStoreEnable(){
        $companyCategory =   CompanyCategory::where('id',self::companyId())->first();
        if($companyCategory->is_store == 1){
          return true;
        }else{
            return false;
        }

      }
      public static function isInventoryAdjustAuto(){
        $approbalValue =   self::geSetupValue("inventory_adjust_approval");
        if($approbalValue == "Auto Approval"){
          return true;
        }else{
            return false;
        }
      }

      public static function isPaymentVoucherAuto(){
        $approbalValue =   self::geSetupValue("payment_voucher_approval");
        if($approbalValue == "Auto Approval"){
          return true;
        }else{
            return false;
        }
      }

      public static function isReceiveVoucherAuto(){
        $approbalValue =   self::geSetupValue("receive_voucher_approval");
        if($approbalValue == "Auto Approval"){
          return true;
        }else{
            return false;
        }
      }

      public static function isJournalVoucherAuto(){
        $approbalValue =   self::geSetupValue("journal_voucher_approval");
        if($approbalValue == "Auto Approval"){
          return true;
        }else{
            return false;
        }
      }


    public static function branchIsActive(){
        $approbalValue =   self::geSetupValue("is_branch");
        if($approbalValue == 'No'){
            return false;
        }else{
            return true;
        }

      }


      public static function storeIsActive(){
        $approbalValue =   self::geSetupValue("is_store");
        if($approbalValue == 1){
            return true;
        }else{
            return false;
        }

      }

    public static function statusBar($status)
    {
        $statusBar = '';
        if($status == 'Approved'){
         $statusBar ='<span class="badge badge-success"><i class="fa fa-check"></i> Approved</span>';
        }elseif($status == 'Pending'){
         $statusBar ='<span class="badge badge-warning"><i class="fas fa-spinner fa-spin"></i> Pending</span>';
        }elseif($status == 'Partial Received'){
         $statusBar ='<span class="badge badge-primary"><i class="fas fa-spinner fa-spin"></i> Partial</span>';
        }elseif($status == 'Partial Payment'){
         $statusBar ='<span class="badge badge-primary"><i class="fas fa-spinner fa-spin"></i> Partial</span>';
        }elseif($status == 'Cancel'){
         $statusBar ='<span class="badge badge-secondary"><i class="fa fa-times"></i> Cancel</span>';
        }elseif($status == 'Dishonoured'){
         $statusBar ='<span class="badge badge-danger"><i class="fa fa-times"></i> Dishonoured</span>';
        }else{
         $statusBar ='<span class="badge badge-info"><i class="fas fa-spinner fa-spin"></i> Inactive</span>';
        }
        return $statusBar;
    }


    public static function getOrderList(){
       $pendingRequsitionList =  PurchasesOrder::select('id','voucher_no as name')->where('purchases_status','Pending')->where('order_status','Approved')->get();
       return $pendingRequsitionList;
    }

    public static function getPosProductList(){
       $posProductList =  Product::select('id','name')->where('type_id','POS Product')->where('status','Approved')->get();
       return $posProductList;
    }


 public static function getRequisitionList($editInfo=null,$updateValue=null){
        if(!empty($updateValue) && isset($updateValue->id)):
            $pendingRequsitionList =  PurchaseRequisition::select('id','voucher_no as name')->where('id',$updateValue->requisition_id)->get();
        else:
            $pendingRequsitionList =  PurchaseRequisition::select('id','voucher_no as name')->where('purchases_order_status','Pending')->where('requisition_status','Approved')->get();
        endif;
       return $pendingRequsitionList;
    }

    public static function getSalesQuatationList($editInfo=null,$updateValue=null){
        if(!empty($updateValue) && isset($updateValue->id)):
            $pendingSalesQuatation =  SalesQuatation::select('id','voucher_no as name')->where('id',$updateValue->sales_quatation_id)->get();
        else:
            $pendingSalesQuatation =  SalesQuatation::select('id','voucher_no as name')->where('sales_status','Pending')->where('quatation_status','Approved')->get();
        endif;
       return $pendingSalesQuatation;
    }

    public static function getServiceQuatationList($editInfo=null,$updateValue=null){
        if(!empty($updateValue) && isset($updateValue->id)):
            $pendingServiceQuatation =  ServiceQuatation::select('id','voucher_no as name')->where('id',$updateValue->service_quatation_id)->get();
        else:
            $pendingServiceQuatation =  ServiceQuatation::select('id','voucher_no as name')->where('service_status','Pending')->where('quatation_status','Approved')->get();
        endif;
       return $pendingServiceQuatation;
    }

    public static function getPurchasesList($editInfo=null,$updateValue=null){
        if(!empty($updateValue) && isset($updateValue->id)):
            $pendingPurchases =  Purchases::select('id','voucher_no as name')->where('id',$updateValue->purchases_id)->get();
        else:
            $pendingPurchases =  Purchases::select('id','voucher_no as name')->whereIn('mrr_status',['Pending',"Partial Received"])->where('purchases_status','Approved')->get();
        endif;
       return $pendingPurchases;
    }

    public static function getSalesList($editInfo=null,$updateValue=null){
        if(!empty($updateValue) && isset($updateValue->id)):
            $pendingSales =  Sales::select('id','voucher_no as name')->where('id',$updateValue->sales_id)->get();
        else:
            $pendingSales =  Sales::select('id','voucher_no as name')->whereIn('challan_status',['Pending',"Partial Received"])->where('sales_status','Approved')->get();

        endif;
       return $pendingSales;
    }


    public static function getSetupData($parameter){
        $setupData = GeneralTable::select('value as id','value as name')->where('type',$parameter)->get();
        return $setupData;
    }




    public static function getBankInfo(){
       $bankList =  Bank::select(DB::raw("CONCAT(banks.bank_name,' [ ',banks.account_number,' ]') as name,banks.id"))->get();
    //    $bankList =  Bank::select(DB::raw("CONCAT(banks.bank_name,' [ ',banks.account_number,' ]') as name,CONCAT(banks.bank_name,' [ ',banks.account_number,' ]') as id"))->get();
        return $bankList;
    }
    
    

    public static function getStockExitsProductList(){
        $result = StockSummary::select('id','product_id','quantity','batch_no','branch_id','store_id','pack_size')->with('product','batch')->havingRaw('quantity > 1')->company()->get();
          return $result;
    }

    public static function getProductBatchById($productId){
        $result = StockSummary::select('id','product_id','quantity','batch_no','branch_id','store_id','pack_size')->with('product','batch')->where('product_id',$productId)->havingRaw('quantity > 1')->company()->first();
          return $result->batch_no ?? 0;
    }

    public static function isAccountApprovalAuto(){
        $approbalValue =   self::geSetupValue("account_approval");
        if($approbalValue == "Auto Approval"){
          return true;
        }else{
            return false;
        }

      }

    public static function isSalesReturnApprovalAuto(){
        $approbalValue =   self::geSetupValue("sales_return_approval");
        if($approbalValue == "Auto Approval"){
          return true;
        }else{
            return false;
        }

      }

    public static function isPurchasesReturnApprovalAuto(){
        $approbalValue =   self::geSetupValue("purchases_return_approval");
        if($approbalValue == "Auto Approval"){
          return true;
        }else{
            return false;
        }

      }

    public static function getPaymentType(){
       $paymentTypeList =  PaymentType::select(DB::raw("CONCAT(payment_types.name) as name,CONCAT(payment_types.name) as id"))->get();
       foreach($paymentTypeList as $key => $value):
         (string) $value->id = $value->name;
          $value->name = $value->name;
       endforeach;
       return $paymentTypeList;
    }

    public static function getCashAndBankPaymentType(){
       $paymentTypeList =  PaymentType::select(DB::raw("CONCAT(payment_types.name) as name,CONCAT(payment_types.name) as id"))->whereNotIn('name',['credit'])->get();
       foreach($paymentTypeList as $key => $value):
        if($value->name !="Credit"){
            (string) $value->id = $value->name;
            $value->name = $value->name;
        }
       endforeach;

       return $paymentTypeList;
    }

    public static function upload($image, $width,$height,$folder,$id=null)
    {
        if ($image && !empty($image)) {
            $ext = $image->getClientOriginalExtension();
            $fileName = rand(100,1000).time() . "." . $ext;
            $img = Image::make($image)->resize($width, $height);
            $img = Image::make($image)->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->stream();
            if(is_null($id)){
                $upload_path = 'public/uploads/'.$folder .'/';
            }else{
                $upload_path = 'public/uploads/'.$folder .'/'.$id.'/';
            }

             if (!Storage::exists($upload_path)) {
                Storage::makeDirectory($upload_path, 0775, true, true);
            }
            $upload_path = $upload_path.$fileName;
            Storage::disk('local')->put($upload_path, $img, 'public');
            return $upload_path;
        }
    }

    
    public static function imageUrl($image){
        try
        {
           $valid_image = str_replace("public","storage",$image);
           if(!empty($valid_image)):
            getimagesize($valid_image);
            $imageUrl='/'.$valid_image;
            endif;
        } catch (\Exception $e)
        {
            $imageUrl =   'assets/images/image-not-found.png';

        }
        return $imageUrl ?? '';

    }


    public static function pImageUrl($image){
        try
        {
           $valid_image = str_replace("public","storage",$image);
            getimagesize($valid_image);
            $imageUrl=$valid_image;
        } catch (\Exception $e)
        {
            $imageUrl =   'assets/images/image-not-found.png';

        }
        return $imageUrl ?? '';

    }

    public static function getProductListCategoryWise(){
        $companyId = helper::companyId();

       $productListCategoryWise =  Category::whereHas('products',function($q) use ($companyId){
        $q->where('company_id',$companyId)->where('type_id','POS Product');
       })->get();
       return $productListCategoryWise;
    }



    public static function getServiceListCategoryWise(){
        $companyId = helper::companyId();
       $serviceListCategoryWise =  ServiceCategory::whereHas('sevices',function($q) use ($companyId){
           $q->where('company_id',$companyId);
       })->get();
       return $serviceListCategoryWise;
    }




    public static function get_bd_amount_in_text($amount) {
        $output_string = '';
        $tokens = explode('.', $amount);
        $current_amount = $tokens[0];
        $fraction = '';
        if (count($tokens) > 1) {
            $fraction = (double) ('0.' . $tokens[1]);
            $fraction = $fraction * 100;
            $fraction = round($fraction, 0);
            $fraction = (int) $fraction;
            $fraction = self::translate_to_words($fraction) . ' Poisa';
            $fraction = ' Taka & ' . $fraction;
        }
        $crore = 0;
        if ($current_amount >= pow(10, 7)) {
            $crore = (int) floor($current_amount / pow(10, 7));
            $output_string .= self::translate_to_words($crore) . ' crore ';
            $current_amount = $current_amount - $crore * pow(10, 7);
        }
        $lakh = 0;
        if ($current_amount >= pow(10, 5)) {
            $lakh = (int) floor($current_amount / pow(10, 5));
            $output_string .= self::translate_to_words($lakh) . ' lakh ';
            $current_amount = $current_amount - $lakh * pow(10, 5);
        }
        $current_amount = (int) $current_amount;
        $output_string .= self::translate_to_words($current_amount);
        $output_string = $output_string . $fraction . ' only';
        $output_string = ucwords($output_string);
        return $output_string;
    }




    public static function translate_to_words($number) {
        /*         * ***
         * A recursive function to turn digits into words
         * Numbers must be integers from -999,999,999,999 to 999,999,999,999 inclussive.
         */
        // zero is a special case, it cause problems even with typecasting if we don't deal with it here
        $max_size = pow(10, 18);
        if (!$number)
            return "zero";
        if (is_int($number) && $number < abs($max_size)) {
            $prefix = '';
            $suffix = '';
            switch ($number) {
                // setup up some rules for converting digits to words
                case $number < 0:
                    $prefix = "negative";
                    $suffix = self::translate_to_words(-1 * $number);
                    $string = $prefix . " " . $suffix;
                    break;
                case 1:
                    $string = "one";
                    break;
                case 2:
                    $string = "two";
                    break;
                case 3:
                    $string = "three";
                    break;
                case 4:
                    $string = "four";
                    break;
                case 5:
                    $string = "five";
                    break;
                case 6:
                    $string = "six";
                    break;
                case 7:
                    $string = "seven";
                    break;
                case 8:
                    $string = "eight";
                    break;
                case 9:
                    $string = "nine";
                    break;
                case 10:
                    $string = "ten";
                    break;
                case 11:
                    $string = "eleven";
                    break;
                case 12:
                    $string = "twelve";
                    break;
                case 13:
                    $string = "thirteen";
                    break;
                // fourteen handled later
                case 15:
                    $string = "fifteen";
                    break;
                case $number < 20:
                    $string = self::translate_to_words($number % 10);
                    // eighteen only has one "t"
                    if ($number == 18) {
                        $suffix = "een";
                    } else {
                        $suffix = "teen";
                    }
                    $string .= $suffix;
                    break;
                case 20:
                    $string = "twenty";
                    break;
                case 30:
                    $string = "thirty";
                    break;
                case 40:
                    $string = "forty";
                    break;
                case 50:
                    $string = "fifty";
                    break;
                case 60:
                    $string = "sixty";
                    break;
                case 70:
                    $string = "seventy";
                    break;
                case 80:
                    $string = "eighty";
                    break;
                case 90:
                    $string = "ninety";
                    break;
                case $number < 100:
                    $prefix = self::translate_to_words($number - $number % 10);
                    $suffix = self::translate_to_words($number % 10);
                    //$string = $prefix . "-" . $suffix;
                    $string = $prefix . " " . $suffix;
                    break;
                // handles all number 100 to 999
                case $number < pow(10, 3):
                    // floor return a float not an integer
                    $prefix = self::translate_to_words(intval(floor($number / pow(10, 2)))) . " hundred";
                    if ($number % pow(10, 2))
                        $suffix = " and " . self::translate_to_words($number % pow(10, 2));
                    $string = $prefix . $suffix;
                    break;
                case $number < pow(10, 6):
                    // floor return a float not an integer
                    $prefix = self::translate_to_words(intval(floor($number / pow(10, 3)))) . " thousand";
                    if ($number % pow(10, 3))
                        $suffix = self::translate_to_words($number % pow(10, 3));
                    $string = $prefix . " " . $suffix;
                    break;
            }
        } else {
            echo "ERROR with - $number Number must be an integer between -" . number_format($max_size, 0, ".", ",") . " and " . number_format($max_size, 0, ".", ",") . " exclussive.";
        }
        return $string;
    }


    public static function convert_number_to_words($number) {

        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . Self::convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . Self::convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = Self::convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= Self::convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }


/*for website method */

public static function productRating($product_id){
  $review =   Review::select("rating")->where('product_id',$product_id)->avg('rating');
  return $review ?? 0;

}



}
