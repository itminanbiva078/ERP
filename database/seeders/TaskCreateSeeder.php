<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\TaskCreate;
use App\Models\FormInput;

class TaskCreateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
         $unixTimestamp =time();
        for ($i = 0; $i < 2; $i++) :
            $taskCreate = new TaskCreate();
            $taskCreate->project_id = rand(1,10);
            $taskCreate->company_id = 1;
            $taskCreate->task_categorie_id =  rand(1,10);
            $taskCreate->employee_id =  rand(1,10);
            $taskCreate->name =   $faker->name;
            $taskCreate->description =  'default text';
            $taskCreate->start_date =$faker->date;
            $taskCreate->end_date =$faker->date;
            $taskCreate->updated_by = 1;
            $taskCreate->created_by = 1;
            $taskCreate->deleted_by = 1;
            $taskCreate->save();
        endfor;


        $formStructure =  array(
            'name' => 'task_creates',
            'input_field' => array(
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Name',
                    'placeholder' => 'Name',
                    'value' => null,
                    'required' => null,
                    'tableshow' => true,
                    'inputShow' => true,
                    'unique' => false,
                    'validation' => 'required|max:100|min:2',
                ),
                array(
                    'name' => 'project_id',
                    'type' => 'select',
                    'class' => 'form-control select2 project_id',
                    'id' => null,
                    'label' => 'Project',
                    'placeholder' => 'Please select Project',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'projects',
                    'customMethod' => null,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'task_categorie_id',
                    'type' => 'select',
                    'class' => 'form-control select2 task_categorie_id',
                    'id' => null,
                    'label' => 'Task Category',
                    'placeholder' => 'Please select Task Category',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'task_categories',
                    'customMethod' => null,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'employee_id',
                    'type' => 'select',
                    'class' => 'form-control select2 employee_id',
                    'id' => null,
                    'label' => 'Assign Person',
                    'placeholder' => 'Please select Assign Person',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'foreignTable' => 'employees',
                    'customMethod' => null,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'end_date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Start Date',
                    'placeholder' => 'Start Date',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'validation' => 'required',
                ),
                array(
                    'name' => 'start_date',
                    'type' => 'date',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'End Date',
                    'placeholder' => 'End Date',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => false,
                    'inputShow' => true,
                    'validation' => 'required',
                ),
             
                array(
                    'name' => 'priority',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Priority',
                    'placeholder' => 'Priority',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                ),

                array(
                    'name' => 'file',
                    'type' => 'file',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'File Upload',
                    'placeholder' => 'File Upload',
                    'value' => null,
                    'required' => null,
                    'tableshow' => false,
                    'unique' => false,
                    'inputShow' => true,
                ),

                array(
                    'name' => 'description',
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Description',
                    'placeholder' => 'Description',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => true,
                ),
                array(
                    'name' => 'time',
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => null,
                    'label' => 'Time',
                    'placeholder' => 'Time',
                    'value' => null,
                    'required' => null,
                    'unique' => false,
                    'tableshow' => true,
                    'inputShow' => false,
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
