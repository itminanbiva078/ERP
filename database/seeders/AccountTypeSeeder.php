<?php
namespace Database\Seeders;
use App\Models\AccountType;
use App\Models\FormInput;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $accountType=array(
            'Customer',
            'Supplier',
            'Income',
            'Expense',
            'Others',
        );
        foreach ($accountType as $key => $value) :
            $accountTypeInfo = new AccountType();
            $accountTypeInfo->name = $value;
            $accountTypeInfo->company_id = 1;
            $accountTypeInfo->updated_by = 1;
            $accountTypeInfo->created_by = 1;
            $accountTypeInfo->deleted_by = 1;
            $accountTypeInfo->save();
        endforeach;
        $formStructure =  array(
            'name' => 'account_types',
            'input_field' => array(
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Type Name',
                    'placeholder' => 'Type Name',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',
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
