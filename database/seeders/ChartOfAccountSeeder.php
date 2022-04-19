<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\ChartOfAccount;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ChartOfAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $mainArray =
            array(
                (object) array(
                    'label' => 'Assets',
                    'parent_id' => 0,
                    'secondLabel' => (object) array(
                        (object) array(
                            'label' => 'Current Assets',
                            'parent_id' => null,
                            'thirdLabel' => (object) array(
                                (object) array(
                                    'label' => 'Inventories',
                                    'forthLabel' =>
                                    (object) array(
                                        'Inventory stock',
                                        'Goods Receive Clear Accounts',
                                        'New Cylinder Stock',
                                    ),

                                ),
                                (object) array(
                                    'label' => 'Cash in Hand',
                                ),
                                (object) array(
                                    'label' => 'Cash in Bank',
                                    'forthLabel' =>
                                    (object) array(
                                        'IBBL',
                                        'DBBL',
                                        'Bank Asia',
                                    ),

                                ),
                                (object) array(
                                    'label' => 'Account Receivable',
                                ),
                                (object) array(
                                    'label' => 'Advance against rent',
                                ),
                                (object) array(
                                    'label' => 'Advance against salary',
                                ),
                                (object) array(
                                    'label' => 'Store Cash in Hand',
                                ),
                                (object) array(
                                    'label' => 'AIT',
                                ),
                            )
                        ),
                        (object) array(
                            'label' => 'Fixed Assets',
                            'parent_id' => null,
                            'thirdLabel' => (object) array(
                                (object) array(
                                    'label' => 'Property Plan & Equipment',
                                    'forthLabel' =>
                                    (object) array(
                                        'Land and Land Development',
                                        'Building',
                                        'Furniture & Fixture',
                                        'Computer',
                                        'Air Conditioner',
                                        'Equipment',
                                        'Decoration',
                                        'Warehouse Equipment',
                                        'Vehicle',
                                        'Trawler',
                                    ),

                                ),
                                (object) array(
                                    'label' => 'Investment',
                                    'forthLabel' =>
                                    (object) array(
                                        'FDR',
                                    ),

                                ),
                            )
                        ),
                        
                    )
                ),
                (object) array(
                    'label' => 'Capital & Liabilites',
                    'parent_id' => 0,
                    'secondLabel' => (object) array(
                        (object) array(
                            'label' => 'Capital',
                            'parent_id' => null,
                            'thirdLabel' => (object) array(
                                (object) array(
                                    'label' => 'Paid up Capital',
                                ),

                            )
                        ),
                        (object) array(
                            'label' => 'Non-Current Liability',
                            'parent_id' => null,
                            'thirdLabel' => (object) array(
                                (object) array(
                                    'label' => 'Bank loan',
                                ),
                                (object) array(
                                    'label' => 'Director Loan',
                                ),
                            )
                        ),
                        (object) array(
                            'label' => 'Current Liability',
                            'parent_id' => null,
                            'thirdLabel' => (object) array(
                                (object) array(
                                    'label' => 'Account Payables',
                                ),
                                (object) array(
                                    'label' => 'Sales Tax',
                                ),
                                (object) array(
                                    'label' => 'VAT Account',
                                ),
                            )
                        ),
                    )
                ),

                (object) array(
                    'label' => 'Income',
                    'parent_id' => 0,
                    'secondLabel' => (object) array(
                        (object) array(
                            'label' => 'Sales Revenue',
                            'parent_id' => null,
                            'thirdLabel' => (object) array(
                                (object) array(
                                    'label' => 'Service Sales',
                                ),
                                (object) array(
                                    'label' => 'Sales',
                                ),
                                (object) array(
                                    'label' =>  'Prompt Payment Discount',
                                ),
                            )
                        ),
                        (object) array(
                            'label' => 'Bank Interest',
                        ),
                        (object) array(
                            'label' => 'Others Income',
                            'parent_id' => null,
                            'thirdLabel' => (object) array(
                                (object) array(
                                    'label' => 'Loader',
                                ),
                                (object) array(
                                    'label' =>  'Transportation',
                                ),
                            )
                        ),
                    )
                ),

                (object) array(
                    'label' => 'Expense',
                    'parent_id' => 0,
                    'secondLabel' => (object) array(
                        (object) array(
                            'label' => 'Cost of Goods',
                            'parent_id' => null,
                            'thirdLabel' => (object) array(
                                (object) array(
                                    'label' => 'Cost of Goods Product',
                                ),
                                (object) array(
                                    'label' => 'Packing Materials',
                                ),
                                (object) array(
                                    'label' => 'Loading & Wages',
                                ),
                                (object) array(
                                    'label' => 'Labour Expense',
                                ),
                                (object) array(
                                    'label' => 'Selling Expense',
                                ),
                                (object) array(
                                    'label' => 'Transportation',
                                ),
                            )
                        ),
                        
                        (object) array(
                            'label' => 'Administrative Expense',
                            'parent_id' => null,
                            'thirdLabel' => (object) array(
                                (object) array(
                                    'label' => 'Loader',
                                ),
                                (object) array(
                                    'label' =>  'Transportation',
                                ),
                                (object) array(
                                    'label' => 'Discount',
                                ),
                                (object) array(
                                    'label' => 'Staff Salary',
                                ),
                                (object) array(
                                    'label' => 'Festival Bonus',
                                ),
                                (object) array(
                                    'label' => 'Printing',
                                ),
                                (object) array(
                                    'label' => 'Stationary',
                                ),
                                (object) array(
                                    'label' => 'Photocopy',
                                ),
                                (object) array(
                                    'label' => 'Conveyance',
                                ),
                                (object) array(
                                    'label' => 'Travel',
                                ),
                                (object) array(
                                    'label' => 'Staff Food',
                                ),
                                (object) array(
                                    'label' => 'Office Entertainment',
                                ),
                                (object) array(
                                    'label' => 'Guest Entertainment',
                                ),
                                (object) array(
                                    'label' => 'Incentive',
                                ),
                                (object) array(
                                    'label' => 'Internet',
                                ),
                                (object) array(
                                    'label' => 'Mobile Bill',
                                ),
                                (object) array(
                                    'label' => 'Postage & Courier',
                                ),
                                (object) array(
                                    'label' => 'Office Rent',
                                ),
                                (object) array(
                                    'label' => 'Godown',
                                ),
                                (object) array(
                                    'label' => 'Water',
                                ),
                                (object) array(
                                    'label' => 'Gas',
                                ),
                                (object) array(
                                    'label' => 'Electricity',
                                ),
                                (object) array(
                                    'label' => 'T & T',
                                ),
                                (object) array(
                                    'label' => 'Vehicale Maintenance',
                                ),
                                (object) array(
                                    'label' => 'Repair Maintenance',
                                ),
                                (object) array(
                                    'label' => 'Cleaning',
                                ),
                                (object) array(
                                    'label' => 'Paper & Periodicals',
                                ),
                                (object) array(
                                    'label' => 'Gift',
                                ),
                                (object) array(
                                    'label' => 'Bank charge',
                                ),

                            )
                        ),
                    )
                ),

            );

        ChartOfAccount::truncate();
        foreach ((object) $mainArray as $key => $firstLabel) :
            $parent =  new ChartOfAccount();
            $parent->name = $firstLabel->label;
            $parent->account_code =  'AC' . str_pad($key +1, 6, "0", STR_PAD_LEFT);
            $parent->parent_id = 0;
            $parent->save();
            if ($firstLabel->secondLabel) :
                foreach ($firstLabel->secondLabel as $key1 => $eachSsecond) :
                    $secondLabel =  new ChartOfAccount();
                    $secondLabel->name = $eachSsecond->label;
                    $secondLabel->parent_id = $parent->id;
                    $secondLabel->account_code = 'AC' . str_pad($key+$key1 +1, 6, "0", STR_PAD_LEFT);
                    $secondLabel->company_id = 1;
                    $secondLabel->save();
                    if (!empty($eachSsecond->thirdLabel)) {
                        foreach ($eachSsecond->thirdLabel as $key2 => $eachThird) :
                            $thirdLabel =  new ChartOfAccount();
                            $thirdLabel->name = $eachThird->label;
                            $thirdLabel->parent_id = $secondLabel->id;
                            $thirdLabel->account_code = 'AC' . str_pad($key+$key2 +1, 6, "0", STR_PAD_LEFT);
                            $thirdLabel->company_id = 1; // $secondLabel->id;
                            if (empty($eachThird->forthLabel))
                                $thirdLabel->is_posted = 1; //$secondLabel->id;
                            $thirdLabel->save();
                            if (!empty($eachThird->forthLabel)) {
                                foreach ($eachThird->forthLabel as $key3 => $eachLabel) :
                                    $forthlabel =  new ChartOfAccount();
                                    $forthlabel->name = $eachLabel;
                                    $thirdLabel->account_code = 'AC' . str_pad($key+$key3 +1, 6, "0", STR_PAD_LEFT);
                                    $forthlabel->parent_id = $thirdLabel->id;
                                    $forthlabel->company_id = 1; // $thirdLabel->id;
                                    $forthlabel->is_posted = 1; //$thirdLabel->id;
                                    $forthlabel->save();
                                endforeach;
                            }
                        endforeach;
                    }

                endforeach;
            endif;
        endforeach;

        $formStructure = array(
            'name' => 'chart_of_accounts',
            'input_field' => array(

               
                array(
                    'name' => 'account_code',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Account Code',
                    'placeholder' => 'Account Code',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => false,
                    'unique' => false,
                    'validation' => 'required',
                    'readonly' => 'readonly',
                    'voucherInfo' => "account_prefix-chart_of_accounts",
                ),
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Account Name',
                    'placeholder' => 'Account Name',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => false,
                    'unique' => false,
                    'validation' => 'required|min:2',

                ),

                array(
                    'name' => 'parent_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Parent account',
                    'placeholder' => 'Please type parent account',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => false,
                    'unique' => false,
                    'foreignTable' => 'chart_of_accounts',
                    'customMethod' => null,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'account_type_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Account Type',
                    'placeholder' => 'Please type account type',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => false,
                    'unique' => false,
                    'foreignTable' => 'account_types',
                    'customMethod' => null,
                    'validation' => 'required',
                ),

                array(
                    'name' => 'branch_id',
                    'type' => 'select',
                    'class' => 'form-control select2 branch_id',
                    'id' => null,
                    'label' => 'Branch',
                    'placeholder' => 'Please select branch',
                    'value' => null,
                    'required' => null,
                    'inputShow' => false,
                    'tableshow' => false,
                    'unique' => false,
                    'foreignTable' => 'branches',
                    'customMethod' => null,
                    'validation' => 'nullable',
                ),
               
                array(
                    'name' => 'is_posted',
                    'type' => 'checkbox',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Posted as Ledger',
                    'placeholder' => 'Posted as Ledger',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'inputShow' => true,
                    'tableshow' => true,
                    'foreignTable' => true,
                    'validation' => 'nullable',
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
                    'tableshow' => false,
                    'inputShow' => true,
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