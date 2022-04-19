<?php

use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'TaskSetup'], function () {

                //task category crud operation start
                Route::get('/task-setup-task-category-list', 'TaskCategoryController@index')->name('taskSetup.taskCategory.index');
                Route::get('/dataProcessingTaskCategory', 'TaskCategoryController@dataProcessingTaskCategory')->name('taskSetup.taskCategory.dataProcessingTaskCategory');
                Route::get('/task-setup-task-category-create', 'TaskCategoryController@create')->name('taskSetup.taskCategory.create');
                Route::post('/task-setup-task-category-store', 'TaskCategoryController@store')->name('taskSetup.taskCategory.store');
                Route::get('/task-setup-task-category-edit/{id}', 'TaskCategoryController@edit')->name('taskSetup.taskCategory.edit');
                Route::post('/task-setup-task-category-update/{id}', 'TaskCategoryController@update')->name('taskSetup.taskCategory.update');
                Route::get('/task-setup-task-category-delete/{id}', 'TaskCategoryController@destroy')->name('taskSetup.taskCategory.destroy');
                Route::get('/task-setup-task-category-status/{id}/{status}', 'TaskCategoryController@statusUpdate')->name('taskSetup.taskCategory.status');
                Route::post('/task-setup-task-category-import', 'TaskCategoryController@taskCategoryImport')->name('taskSetup.taskCategory.import');
                Route::get('/task-setup-task-category-explode', 'TaskCategoryController@taskCategoryExplode')->name('taskSetup.taskCategory.explode');
                //task category crud operation end


                //task status Group crud operation start
                Route::get('/task-setup-task-status-group-list', 'TaskStatusController@index')->name('taskSetup.taskStatus.index');
                Route::get('/dataProcessingTaskStatus', 'TaskStatusController@dataProcessingTaskStatus')->name('taskSetup.taskStatus.dataProcessingTaskStatus');
                Route::get('/task-setup-task-status-group-create', 'TaskStatusController@create')->name('taskSetup.taskStatus.create');
                Route::post('/task-setup-task-status-group-store', 'TaskStatusController@store')->name('taskSetup.taskStatus.store');
                Route::get('/task-setup-task-status-group-edit/{id}', 'TaskStatusController@edit')->name('taskSetup.taskStatus.edit');
                Route::post('/task-setup-task-status-group-update/{id}', 'TaskStatusController@update')->name('taskSetup.taskStatus.update');
                Route::get('/task-setup-task-status-group-delete/{id}', 'TaskStatusController@destroy')->name('taskSetup.taskStatus.destroy');
                Route::get('/task-setup-task-status-group-status/{id}/{status}', 'TaskStatusController@statusUpdate')->name('taskSetup.taskStatus.status');
                Route::post('/task-setup-task-status-group-import', 'TaskStatusController@taskStatusImport')->name('taskSetup.taskStatus.import');
                Route::get('/task-setup-task-status-group-explode', 'TaskStatusController@taskStatusExplode')->name('taskSetup.taskStatus.explode');
                //task status Group crud operation end

      
    });


        Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'TaskTransaction'], function () {

                //task create crud operation start
                Route::get('/task-transaction-task-create-list', 'TaskCreateController@index')->name('taskTransaction.taskCreate.index');
                Route::get('/dataProcessingTaskCreate', 'TaskCreateController@dataProcessingTaskCreate')->name('taskTransaction.taskCreate.dataProcessingTaskCreate');
                Route::get('/task-transaction-task-create', 'TaskCreateController@create')->name('taskTransaction.taskCreate.create');
                Route::post('/task-transaction-task-create-store', 'TaskCreateController@store')->name('taskTransaction.taskCreate.store');
                Route::get('/task-transaction-task-create-edit/{id}', 'TaskCreateController@edit')->name('taskTransaction.taskCreate.edit');
                Route::get('/task-transaction-task-create-show/{id}', 'TaskCreateController@show')->name('taskTransaction.taskCreate.show');
                Route::post('/task-transaction-task-create-update/{id}', 'TaskCreateController@update')->name('taskTransaction.taskCreate.update');
                Route::get('/task-transaction-task-create-delete/{id}', 'TaskCreateController@destroy')->name('taskTransaction.taskCreate.destroy');
                Route::get('/task-transaction-task-create-status/{id}/{status}', 'TaskCreateController@statusUpdate')->name('taskTransaction.taskCreate.status');
                //task create crud operation end
        

});

});
