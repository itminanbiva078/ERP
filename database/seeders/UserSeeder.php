<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\FormInput;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        if (is_null($user)) {
            $user = new User();
            $user->company_id = 1;
            $user->role_id = 1;
            $user->name = "Nptl";
            $user->phone = "01793002925";
            $user->email = "admin@gmail.com";
            $user->password = Hash::make('12345678');
            $user->save();
        }

        $formStructure = array(
            'name' => 'users',
            'input_field' => array(
                array(
                    'name' => 'role_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Admin role',
                    'placeholder' => 'Please select Admin role',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => 'user_roles',
                    'customMethod' => null,
                    'validation' => 'required',
                   
                ),
                array(
                    'name' => 'company_id',
                    'type' => 'select',
                    'class' => 'form-control select2',
                    'id' => null,
                    'label' => 'Company',
                    'placeholder' => 'Please select company_id',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'foreignTable' => 'company_categories',
                    'customMethod' => null,
                    'validation' => 'required',
                   
                ),
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Full Name',
                    'placeholder' => 'Full Name',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required|max:100|min:2',
                ),
            
                array(
                    'name' => 'email',
                    'type' => 'email',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'E-mail',
                    'placeholder' => 'E-mail',
                    'value' => null,
                    'table' => 'users',
                    'required' => null,
                    'unique' => true,
                    'inputShow' => true,
                    'tableshow' => true,
                    'validation' => 'required|email|unique:users,email',
                ),
                array(
                    'name' => 'phone',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Phone',
                    'placeholder' => 'Phone',
                    'value' => null,
                    'table' => 'users',
                    'unique' => true,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'password',
                    'type' => 'password',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'password',
                    'placeholder' => 'password',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'validation' => 'nullable|confirmed|min:6',

                ),
                array(
                    'name' => 'password_confirmation',
                    'type' => 'password',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Confirm Password',
                    'placeholder' => 'password',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'validation' => 'nullable|min:6',

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







    // [{"name":"role_id","type":"select","class":"form-control select2","id":null,"label":"Admin role","placeholder":"Please select Admin role","value":null,"required":null,"unique":false,"tableshow":false,"foreignTable":"users","validation":"required"},
    // {"name":"company_id","type":"select","class":"form-control select2","id":null,"label":"Company","placeholder":"Please select company_id","value":null,"required":null,"unique":false,"tableshow":false,"foreignTable":"company_categories","validation":"required"},
    // {"name":"name","type":"text","class":"form-control","id":null,"label":"Full Name","placeholder":"Full Name","value":null,"required":null,"unique":false,"tableshow":true,"validation":"required|max:100|min:2"},
    // {"name":"email","type":"email","class":"form-control","id":null,"label":"E-mail","placeholder":"E-mail","value":null,"table":"users","required":null,"unique":true,"tableshow":true,"validation":"required|email|unique:users,email"},
    // {"name":"phone","type":"text","class":"form-control","id":null,"label":"Phone","placeholder":"Phone","value":null,"table":"users","unique":true,"required":null,"tableshow":true,"validation":"required"},
    // {"name":"password","type":"password","class":"form-control","id":null,"label":"password","placeholder":"password","value":null,"required":null,"unique":false,"tableshow":false,"validation":"required"},
    // {"name":"status","type":"select","class":"form-control select2","id":null,"label":"Status","placeholder":"Select Status","value":null,"required":null,"unique":false,"tableshow":true,"foreignTable":"statuses","validation":"nullable"}]
































}