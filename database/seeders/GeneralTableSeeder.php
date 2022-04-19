<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GeneralTable;
use App\Models\FormInput;
use Faker\Generator as Faker;

class GeneralTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $timezone   = array(
            'Africa/Casablanca',
            'Africa/Lagos',
            'Africa/Cairo',
            'Africa/Harare',
            'Africa/Johannesburg',
            'Africa/Monrovia',
            'America/Anchorage',
            'America/Los_Angeles',
            // 'America/Tijuana',
            // 'America/Chihuahua',
            // 'America/Mazatlan',
            // 'America/Denver',
            // 'America/Managua',
            // 'America/Chicago',
            // 'America/Mexico_City',
            // 'America/Monterrey',
            // 'America/New_York',
            // 'America/Lima',
            // 'America/Caracas',
            // 'America/La_Paz',
            // 'America/Santiago',
            // 'America/St_Johns',
            // 'America/Sao_Paulo',
            // 'America/Argentina',
            // 'America/Godthab',
            // 'Asia/Jerusalem',
            // 'Asia/Baghdad',
            // 'Asia/Kuwait',
            // 'Africa/Nairobi',
            // 'Asia/Riyadh',
            // 'Asia/Tehran',
            // 'Asia/Baku',
            // 'Asia/Muscat',
            // 'Asia/Tbilisi',
            // 'Asia/Yerevan',
            // 'Asia/Kabul',
            // 'Asia/Karachi',
            // 'Asia/Tashkent',
            // 'Asia/Kolkata',
            // 'Asia/Katmandu',
            // 'Asia/Almaty',
            // 'Asia/Dhaka',
            // 'Asia/Yekaterinburg',
            // 'Asia/Rangoon',
            // 'Asia/Bangkok',
            // 'Asia/Jakarta',
            // 'Asia/Hong_Kong',
            // 'Asia/Chongqing',
            // 'Asia/Krasnoyarsk',
            // 'Asia/Kuala_Lumpur',
            // 'Australia/Perth',
            // 'Asia/Singapore',
            // 'Asia/Taipei',
            // 'Asia/Ulan_Bator',
            // 'Asia/Urumqi',
            // 'Asia/Irkutsk',
            // 'Asia/Tokyo',
            // 'Asia/Seoul',
            // 'Asia/Yakutsk',
            // 'Asia/Vladivostok',
            // 'Asia/Kamchatka',
            // 'Asia/Magadan',
            // 'Atlantic/Azores',
            // 'Atlantic/Cape_Verde',
            // 'Australia/Adelaide',
            // 'Australia/Darwin',
            // 'Australia/Brisbane',
            // 'Australia/Canberra',
            // 'Australia/Sydney',
            // 'Australia/Hobart',
            // 'Australia/Melbourne',
            // 'Canada/Atlantic',
            // 'Europe/Helsinki',
            // 'Europe/London',
            // 'Europe/Dublin',
            // 'Europe/Lisbon',
            // 'Europe/Belgrade',
            // 'Europe/Berlin',
            // 'Europe/Bratislava',
            // 'Europe/Brussels',
            // 'Europe/Budapest',
            // 'Europe/Copenhagen',
            // 'Europe/Ljubljana',
            // 'Europe/Madrid',
            // 'Europe/Paris',
            // 'Europe/Prague',
            // 'Europe/Sarajevo',
            // 'Europe/Skopje',
            // 'Europe/Stockholm',
            // 'Europe/Vienna',
            // 'Europe/Warsaw',
            // 'Europe/Zagreb',
            // 'Europe/Athens',
            // 'Europe/Bucharest',
            // 'Europe/Riga',
            // 'Europe/Sofia',
            // 'Europe/Tallinn',
            // 'Europe/Vilnius',
            // 'Europe/Minsk',
            // 'Europe/Istanbul',
            // 'Europe/Moscow',
            // 'Pacific/Port_Moresby',
            // 'Pacific/Fiji',
            // 'Pacific/Kwajalein',
            // 'Pacific/Midway',
            // 'Pacific/Samoa',
            // 'Pacific/Honolulu',
            // 'Pacific/Auckland',
            // 'Pacific/Tongatapu',
            // 'Pacific/Guam',
        );
        
        foreach($timezone as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =1;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;

        $dateformat = array(
            'DD-MM-YYYY',
            'YYYY-MM-DD',
            'DD.MM.YYYY',
            'YYYY.MM.DD',
            'DD,MM,YYYY',
            'YYYY,MM,DD',
            'MmmDDYYYY',  
        );
        

        foreach($dateformat as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =2;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;

        $separator = array(
            ',',
            '-',
          
        );
        
        foreach($separator as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =3;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;

        $approval = array(
            'Auto Approval',
            'Pending Approval',
        );

        foreach($approval as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =4;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;

        $discountType = array(
            'Discount %',
            'Fixed Dis',
            'Dis./PCS',
        );
      
        foreach($discountType as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =5;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;

        $currencyPosition = array(
            'Left',
            'Right',   
        );
       
        foreach($currencyPosition as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =6;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;


        $accountPaymentMethod = array(
            'Miscellaneous',
            'Customer',
            'Supplier',
        );
        foreach($accountPaymentMethod as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =7;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;


        $inputType = array(
            'Horizontal',
            'Vertical',
        );
        foreach($inputType as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =8;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;

        $stockAccountMethod = array(
            'FIFO',
            'LIFO',
        );
        foreach($stockAccountMethod as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =9;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;
        
        $mailType = array(
            'Customer',
            'Supplier',
            'Employee',
        );
        foreach($mailType as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =10;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;


        $branchType = array(
            'No',
            'Single Branch',
            'Multiple Branch',
        );
        foreach($branchType as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =11;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;

          $productType = array(
            'POS Product',
            'eCommerce',
            'Rooms',
            // 'Digital Product',
            'Add On',  
        );
        foreach($productType as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =12;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;

        $productAttribute = array(
            'AC',
            'Non AC',
            'Griger',
            'Locker',
            'Common Room',
            'WiFi'  
        );
        foreach($productAttribute as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =13;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;

        $yesNoCondition = array(
            'Yes',
            'NO',
        );
        foreach($yesNoCondition as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =14;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;

        $priceCalculateType = array(
            'Round',
            'Faction',
        );
        foreach($priceCalculateType as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =15;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;
    
    
        $purchasesReportType = array(
            'Ledger',
            'Payment',
            'Cash Payment',
            'Cheque Payment',
            'Pending Cheque',
            'Purchases Voucher',
            'Due Purchases Voucher',
        );
        foreach($purchasesReportType as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =16;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;
    
        $customerWisesaleReportType = array(
            'Ledger',
            'Payment',
            'Cash Payment',
            'Cheque Payment',
            'Pending Cheque',
            'Sale Voucher',
            'Due Sale Voucher',
         );
        foreach($customerWisesaleReportType as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =17;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;
    
    
        $stockReportType = array(
            'Stock Summary',
            'Stock Ledger',
            'Product Ledger',
            'Purchases Ledger',
            'Transfer Send Ledger',
            'Transfer Received Ledger',
            'Purchases Return Ledger',
           
        );
        foreach($stockReportType as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =18;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;



        $salesReportType = array(
            'Sales Ledger',
            'Sales Return Ledger',
            'Top Customer Sales',
            'Top Product Sales',    
           
        );
        foreach($salesReportType as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =20;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;
      
      for($i=0;$i<=25;$i++):
            $generalTable = new GeneralTable();
            $generalTable->type =19;
            $generalTable->value = $i;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endfor;

        $adjustmentType = array(
            
            'In',
            'Out',

         );
        foreach($adjustmentType as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =21;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
        endforeach;


        $collectionType = array(
           
            'Pos Sale',
            'Booking',
            'General Sale',
            
        );
        foreach($collectionType as $value) :
            $generalTable = new GeneralTable();
            $generalTable->type =22;
            $generalTable->value = $value;
            $generalTable->status = 'Approved';
            $generalTable->updated_by = 1;
            $generalTable->created_by = 1;
            $generalTable->deleted_by = 1;
            $generalTable->save();
          endforeach;
      





        $formStructure =  array(
            'name' => 'general_tables',
            'input_field' => array(
              
                array(
                    'name' => 'type',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Type',
                    'placeholder' => 'Type',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'validation' => 'required',
                ),
              
                array(
                    'name' => 'value',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Value',
                    'placeholder' => 'Value',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'validation' => 'required',
                ),
                
                array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Status',
                    'placeholder' => 'Select Status',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
                    'foreignTable' => 'statuses',
                    'customMethod' => null,
                    'validation' => 'nullable',
                ),


            )
        );
        $formInfo = new FormInput();
        $formInfo->navigation_id = null;
        $formInfo->table = $formStructure['name'];
        $formInfo->input = json_encode($formStructure['input_field']);
        $formInfo->save();
    }
}
