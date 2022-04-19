<?php

namespace Database\Seeders;

use App\Models\Smtp;
use App\Models\FormInput;
use Illuminate\Database\Seeder;

class SmtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formStructure = array(
            'name' => 'smtps',
            'input_field' => array(
                array(
                    'name' => 'protocol',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Protocol',
                    'placeholder' => 'Protocol',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                ),
                 array(
                    'name' => 'smtp_host',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'SMTP Host',
                    'placeholder' => 'SMTP',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,

                ),

                array(
                    'name' => 'smtp_port',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Smtp_Port',
                    'placeholder' => 'Smtp_Port',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,

                ),
                array(
                    'name' => 'sender_mail',
                    'type' => 'email',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'E-mail',
                    'placeholder' => 'E-mail',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,

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