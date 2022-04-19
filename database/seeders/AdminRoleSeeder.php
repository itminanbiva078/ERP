<?php

namespace Database\Seeders;

use App\Models\AdminRole;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $unixTimestamp = time();
        for ($i = 0; $i < 2; $i++) :
            $admin_role = new AdminRole();
            $admin_role->admin_role_id = rand(1, 10);
            $admin_role->admin_id = rand(1, 10);
            $admin_role->navigation_id = rand(1, 10);
            $admin_role->parent_id = rand(1, 10);
            $admin_role->test = $faker->text;
            $admin_role->updated_by = 1;
            $admin_role->created_by = 1;
            $admin_role->deleted_by = 1;
            $admin_role->save();
        endfor;

        $formStructure = array(
            'name' => 'admin_roles',
            'input_field' => array(
                array(
                    'name' => 'admin_role_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Admin role',
                    'placeholder' => 'Please select Admin role',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                ),
                array(
                    'name' => 'admin_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'label',
                    'placeholder' => 'Please select admin',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'admin_roles',

                ),
                array(
                    'name' => 'navigation_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Navigation',
                    'placeholder' => 'Please select navigation',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'navigations',

                ),
                array(
                    'name' => 'parent_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Select admin',
                    'placeholder' => 'Please select admin',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    'foreignTable' => 'admin_roles',

                ),
                
                array(
                    'name' => 'test',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Test',
                    'placeholder' => 'test',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
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