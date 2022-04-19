<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Mailbox;
use App\Models\FormInput;
use Faker\Generator as Faker;

class MailboxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $unixTimestamp = time();
        $mailbox = new Mailbox();
        $mailbox->company_id =1;
        $mailbox->from_email = $faker->email;
        $mailbox->to_email = $faker->email;
        $mailbox->email_title = "Hello";
        $mailbox->email_body = $faker->address;
        $mailbox->attachment = $faker->image;
        $mailbox->updated_by = 1;
        $mailbox->created_by = 1;
        $mailbox->deleted_by = 1;
        $mailbox->save();
       


        $formStructure = array(
            'name' => 'mailboxes',
            'input_field' => array(


                array(
                    'name' => 'mail_type',
                    'type' => 'select',
                    'class' => 'form-control select2 mail_type',
                    'id' => null,
                    'label' => 'Type',
                    'placeholder' => 'Type',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'customMethod' => 'getSetupData(10)',
                    'validation' => 'required',
                    
                ),

                array(
                    'name' => 'to_email',
                    'type' => 'email',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'To E-mail',
                    'placeholder' => 'To E-mail',
                    'value' => null,
                    'required' => null,
                    'unique' => true,
                    'tableshow' => true,
                    'inputShow' => true,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'email_title',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Email Title',
                    'placeholder' => 'Email Title',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'unique' => false,
                    'inputShow' => true,
                    'validation' => 'required',

                ),

                array(
                    'name' => 'email_body',
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Email Body',
                    'placeholder' => 'Email Body',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required',
                ),

                array(
                    'name' => 'attachment',
                    'type' => 'file',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Attachment',
                    'placeholder' => 'Attachment',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'inputShow' => true,
                    'unique' => false,
                    // 'validation' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
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
