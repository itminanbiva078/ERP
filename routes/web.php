<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/


Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
        Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Dashboard'], function () {
        Route::get('/home', 'HomeController@index')->name('home');
    });
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Settings'], function () {
        //branch crud operation start
        Route::get('/settings-branch-list', 'BranchController@index')->name('settings.branch.index');
        Route::get('/dataProcessingBranch', 'BranchController@dataProcessingBranch')->name('settings.branch.dataProcessingBranch');
        Route::get('/settings-branch-create', 'BranchController@create')->name('settings.branch.create');
        Route::post('/settings-branch-store', 'BranchController@store')->name('settings.branch.store');
        Route::get('/settings-branch-edit/{id}', 'BranchController@edit')->name('settings.branch.edit');
        Route::post('/settings-branch-update/{id}', 'BranchController@update')->name('settings.branch.update');
        Route::get('/settings-branch-delete/{id}', 'BranchController@destroy')->name('settings.branch.destroy');
        Route::get('/settings-branch-status/{id}/{status}', 'BranchController@statusUpdate')->name('settings.branch.status');
        //branch crud operation end

        //companyCategory crud operation start
        Route::get('/settings-companyCategory-list', 'CompanyCategoryController@index')->name('settings.companyCategory.index');
        Route::get('/dataProcessingCompanyCategory', 'CompanyCategoryController@dataProcessingCompanyCategory')->name('settings.companyCategory.dataProcessingCompanyCategory');
        Route::get('/settings-companyCategory-create', 'CompanyCategoryController@create')->name('settings.companyCategory.create');
        Route::post('/settings-companyCategory-store', 'CompanyCategoryController@store')->name('settings.companyCategory.store');
        Route::get('/settings-companyCategory-edit/{id}', 'CompanyCategoryController@edit')->name('settings.companyCategory.edit');
        Route::post('/settings-companyCategory-update/{id}', 'CompanyCategoryController@update')->name('settings.companyCategory.update');
        Route::get('/settings-companyCategory-delete/{id}', 'CompanyCategoryController@destroy')->name('settings.companyCategory.destroy');
        Route::get('/settings-companyCategory-status/{id}/{status}', 'CompanyCategoryController@statusUpdate')->name('settings.companyCategory.status');
        //companyCategory crud operation end

        //GeneralSetup crud operation start
        Route::get('/settings-general_setup-list', 'GeneralSettingsController@index')->name('settings.generalSetup.index');
        Route::get('/dataProcessingSetup', 'GeneralSettingsController@dataProcessingSetup')->name('settings.generalSetup.dataProcessingSetup');
        Route::get('/settings-general_setup-create', 'GeneralSettingsController@create')->name('settings.generalSetup.create');
        Route::post('/settings-general_setup-store', 'GeneralSettingsController@store')->name('settings.generalSetup.store');
        Route::get('/settings-general_setup-edit/{id}', 'GeneralSettingsController@edit')->name('settings.generalSetup.edit');
        Route::post('/settings-general_setup-update/{id}', 'GeneralSettingsController@update')->name('settings.generalSetup.update');
        Route::get('/settings-general_setup-delete/{id}', 'GeneralSettingsController@destroy')->name('settings.generalSetup.destroy');
        Route::get('/settings-general_setup-status/{id}/{status}', 'GeneralSettingsController@statusUpdate')->name('settings.generalSetup.status');
        //GeneralSetup crud operation end

        //employees crud operation start
        Route::get('/settings-employee-list', 'EmployeeController@index')->name('settings.employee.index');
        Route::get('/dataProcessingEmployee', 'EmployeeController@dataProcessingEmployee')->name('settings.employee.dataProcessingEmployee');
        Route::get('/settings-employee-create', 'EmployeeController@create')->name('settings.employee.create');
        Route::post('/settings-employee-store', 'EmployeeController@store')->name('settings.employee.store');
        Route::get('/settings-employee-edit/{id}', 'EmployeeController@edit')->name('settings.employee.edit');
        Route::post('/settings-employee-update/{id}', 'EmployeeController@update')->name('settings.employee.update');
        Route::get('/settings-employee-delete/{id}', 'EmployeeController@destroy')->name('settings.employee.destroy');
        Route::get('/settings-employee-status/{id}/{status}', 'EmployeeController@statusUpdate')->name('settings.employee.status');
        Route::post('/settings-employee-import', 'EmployeeController@employeeImport')->name('settings.employee.import');
        Route::get('/settings-employee-explode', 'EmployeeController@employeeExplode')->name('settings.employee.explode');
        //employees crud operation end

        //department crud operation start
        Route::get('/settings-department-list', 'DepartmentController@index')->name('settings.department.index');
        Route::get('/dataProcessingDepartment', 'DepartmentController@dataProcessingDepartment')->name('settings.department.dataProcessingDepartment');
        Route::get('/settings-department-create', 'DepartmentController@create')->name('settings.department.create');
        Route::post('/settings-department-store', 'DepartmentController@store')->name('settings.department.store');
        Route::get('/settings-department-edit/{id}', 'DepartmentController@edit')->name('settings.department.edit');
        Route::post('/settings-department-update/{id}', 'DepartmentController@update')->name('settings.department.update');
        Route::get('/settings-department-delete/{id}', 'DepartmentController@destroy')->name('settings.department.destroy');
        Route::get('/settings-department-status/{id}/{status}', 'DepartmentController@statusUpdate')->name('settings.department.status');
        Route::post('/settings-department-import', 'DepartmentController@departmentImport')->name('settings.department.import');
        Route::get('/settings-department-explode', 'DepartmentController@departmentExplode')->name('settings.department.explode');
        //department crud operation end


        //store crud operation start
        Route::get('/settings-store-list', 'StoreController@index')->name('settings.store.index');
        Route::get('/dataProcessingStore', 'StoreController@dataProcessingStore')->name('settings.store.dataProcessingStore');
        Route::get('/settings-store-create', 'StoreController@create')->name('settings.store.create');
        Route::post('/settings-store-store', 'StoreController@store')->name('settings.store.store');
        Route::get('/settings-store-edit/{id}', 'StoreController@edit')->name('settings.store.edit');
        Route::post('/settings-store-update/{id}', 'StoreController@update')->name('settings.store.update');
        Route::get('/settings-store-delete/{id}', 'StoreController@destroy')->name('settings.store.destroy');
        Route::get('/settings-store-status/{id}/{status}', 'StoreController@statusUpdate')->name('settings.store.status');
        Route::get('/settings-store-by-branch', 'StoreController@getStoreByBranch')->name('settings.store.by.branch');
        //store crud operation end

        //navigation crud operation start
        Route::get('/navigation', 'NavigationController@index')->name('setup.index');
        Route::get('/navigation-add', 'NavigationController@create')->name('setup.create');
        Route::post('/navigation-store', 'NavigationController@store')->name('setup.store');
        Route::get('/navigation-edit/{id}', 'NavigationController@edit')->name('setup.edit');
        Route::post('/navigation-edit/{id}', 'NavigationController@update')->name('setup.update');
        Route::delete('/navigation-delete/{id}', 'NavigationController@destroy')->name('setup.destroy');
        //navigation crud operation start

        //smpt crud operation start
        Route::get('/settings-smpt-list', 'SmtpController@index')->name('settings.smpt.index');
        Route::get('/dataProcessingSmpt', 'SmtpController@dataProcessingSmpt')->name('settings.smpt.dataProcessingSmpt');
        Route::get('/settings-smpt-create', 'SmtpController@create')->name('settings.smpt.create');
        Route::post('/settings-smpt-store', 'SmtpController@store')->name('settings.smpt.store');
        Route::get('/settings-smpt-edit/{id}', 'SmtpController@edit')->name('settings.smpt.edit');
        Route::post('/settings-smpt-update/{id}', 'SmtpController@update')->name('settings.smpt.update');
        Route::get('/settings-smpt-delete/{id}', 'SmtpController@destroy')->name('settings.smpt.destroy');
        Route::get('/settings-smpt-status/{id}/{status}', 'SmtpController@statusUpdate')->name('settings.smpt.status');

        //Currency crud operation start
        Route::get('/settings-currency-list', 'CurrencyController@index')->name('settings.currency.index');
        Route::get('/dataProcessingCurrency', 'CurrencyController@dataProcessingCurrency')->name('settings.currency.dataProcessingCurrency');
        Route::get('/settings-currency-create', 'CurrencyController@create')->name('settings.currency.create');
        Route::post('/settings-currency-store', 'CurrencyController@store')->name('settings.currency.store');
        Route::get('/settings-currency-edit/{id}', 'CurrencyController@edit')->name('settings.currency.edit');
        Route::post('/settings-currency-update/{id}', 'CurrencyController@update')->name('settings.currency.update');
        Route::get('/settings-currency-delete/{id}', 'CurrencyController@destroy')->name('settings.currency.destroy');
        Route::get('/settings-currency-status/{id}/{status}', 'CurrencyController@statusUpdate')->name('settings.currency.status');
        //Currency crud operation end

        //language crud operation start
        Route::get('/settings-language-list', 'LanguageController@index')->name('settings.language.index');
        Route::get('/dataProcessingLanguage', 'LanguageController@dataProcessingLanguage')->name('settings.language.dataProcessingLanguage');
        Route::get('/settings-language-create', 'LanguageController@create')->name('settings.language.create');
        Route::post('/settings-language-store', 'LanguageController@store')->name('settings.language.store');
        Route::get('/settings-language-edit/{id}', 'LanguageController@edit')->name('settings.language.edit');
        Route::post('/settings-language-update/{id}', 'LanguageController@update')->name('settings.language.update');
        Route::get('/settings-language-delete/{id}', 'LanguageController@destroy')->name('settings.language.destroy');
        Route::get('/settings-language-status/{id}/{status}', 'LanguageController@statusUpdate')->name('settings.language.status');
        //language crud operation end

        //company crud operation start
        Route::get('/settings-company-list', 'CompanyController@index')->name('settings.company.index');
        Route::get('/dataProcessingCompany', 'CompanyController@dataProcessingCompany')->name('settings.company.dataProcessingCompany');
        Route::get('/settings-company-create', 'CompanyController@create')->name('settings.company.create');
        Route::post('/settings-company-store', 'CompanyController@store')->name('settings.company.store');
        Route::get('/settings-company-edit/{id}', 'CompanyController@edit')->name('settings.company.edit');
        Route::post('/settings-company-update/{id}', 'CompanyController@update')->name('settings.company.update');
        Route::get('/settings-company-delete/{id}', 'CompanyController@destroy')->name('settings.company.destroy');
        Route::get('/settings-company-status/{id}/{status}', 'CompanyController@statusUpdate')->name('settings.company.status');
        //company crud operation end

        //fiscal_year crud operation start
        Route::get('/settings-fiscal_year-list', 'FiscalYearController@index')->name('settings.fiscal_year.index');
        Route::get('/dataProcessingFiscalYear', 'FiscalYearController@dataProcessingFiscalYear')->name('settings.fiscal_year.dataProcessingFiscalYear');
        Route::get('/settings-fiscal_year-create', 'FiscalYearController@create')->name('settings.fiscal_year.create');
        Route::post('/settings-fiscal_year-store', 'FiscalYearController@store')->name('settings.fiscal_year.store');
        Route::get('/settings-fiscal_year-edit/{id}', 'FiscalYearController@edit')->name('settings.fiscal_year.edit');
        Route::post('/settings-fiscal_year-update/{id}', 'FiscalYearController@update')->name('settings.fiscal_year.update');
        Route::get('/settings-fiscal_year-delete/{id}', 'FiscalYearController@destroy')->name('settings.fiscal_year.destroy');
        Route::get('/settings-fiscal_year-status/{id}/{status}', 'FiscalYearController@statusUpdate')->name('settings.fiscal_year.status');
        //fiscal_year crud operation end
        
        //vehicle operation start
        Route::get('/vehicle-list', 'VehicleController@index')->name('settings.vehicle.index');
        Route::get('/dataProcessingVehicles', 'VehicleController@dataProcessingVehicles')->name('settings.vehicle.dataProcessingVehicles');
        Route::get('/vehicle-create', 'VehicleController@create')->name('settings.vehicle.create');
        Route::post('/vehicle-store', 'VehicleController@store')->name('settings.vehicle.store');
        Route::get('/vehicle-edit/{id}', 'VehicleController@edit')->name('settings.vehicle.edit');
        Route::post('/vehicle-update/{id}', 'VehicleController@update')->name('settings.vehicle.update');
        Route::get('/vehicle-delete/{id}', 'VehicleController@destroy')->name('settings.vehicle.destroy');
        Route::get('/vehicle-status/{id}/{status}', 'VehicleController@statusUpdate')->name('settings.vehicle.status');
        //vehicle operation end

             
        //divisions operation start
        Route::get('/division-list', 'DivisionController@index')->name('settings.division.index');
        Route::get('/dataProcessingDivision', 'DivisionController@dataProcessingDivision')->name('settings.division.dataProcessingDivision');
        Route::get('/division-create', 'DivisionController@create')->name('settings.division.create');
        Route::post('/division-store', 'DivisionController@store')->name('settings.division.store');
        Route::get('/division-edit/{id}', 'DivisionController@edit')->name('settings.division.edit');
        Route::post('/division-update/{id}', 'DivisionController@update')->name('settings.division.update');
        Route::get('/division-delete/{id}', 'DivisionController@destroy')->name('settings.division.destroy');
        Route::get('/division-status/{id}/{status}', 'DivisionController@statusUpdate')->name('settings.division.status');
        //divisions operation end

        //district operation start
        Route::get('/district-list', 'DistrictController@index')->name('settings.district.index');
        Route::get('/dataProcessingDistrict', 'DistrictController@dataProcessingDistrict')->name('settings.district.dataProcessingDistrict');
        Route::get('/district-create', 'DistrictController@create')->name('settings.district.create');
        Route::post('/district-store', 'DistrictController@store')->name('settings.district.store');
        Route::get('/district-edit/{id}', 'DistrictController@edit')->name('settings.district.edit');
        Route::post('/district-update/{id}', 'DistrictController@update')->name('settings.district.update');
        Route::get('/district-list-by-divission-id', 'DistrictController@districtListByDivissionId')->name('settings.district.list.divission.id');
        Route::get('/district-delete/{id}', 'DistrictController@destroy')->name('settings.district.destroy');
        Route::get('/district-status/{id}/{status}', 'DistrictController@statusUpdate')->name('settings.district.status');
        //district operation end


        //upzila operation start
        Route::get('/upazila-list', 'UpazilaController@index')->name('settings.upazila.index');
        Route::get('/dataProcessingUpazila', 'UpazilaController@dataProcessingUpazila')->name('settings.upazila.dataProcessingUpazila');
        Route::get('/upazila-create', 'UpazilaController@create')->name('settings.upazila.create');
        Route::post('/upazila-store', 'UpazilaController@store')->name('settings.upazila.store');
        Route::get('/upazila-edit/{id}', 'UpazilaController@edit')->name('settings.upazila.edit');
        Route::post('/upazila-update/{id}', 'UpazilaController@update')->name('settings.upazila.update');
        Route::get('/upazila-list-by-district-id', 'UpazilaController@upazilaListByDistrictId')->name('settings.upazila.list.district.id');
        Route::get('/upazila-delete/{id}', 'UpazilaController@destroy')->name('settings.upazila.destroy');
        Route::get('/upazila-status/{id}/{status}', 'UpazilaController@statusUpdate')->name('settings.upazila.status');
        //upzila operation end

        //union operation start
        Route::get('/union-list', 'UnionController@index')->name('settings.union.index');
        Route::get('/dataProcessingUnion', 'UnionController@dataProcessingUnion')->name('settings.union.dataProcessingUnion');
        Route::get('/union-create', 'UnionController@create')->name('settings.union.create');
        Route::post('/union-store', 'UnionController@store')->name('settings.union.store');
        Route::get('/union-edit/{id}', 'UnionController@edit')->name('settings.union.edit');
        Route::post('/union-update/{id}', 'UnionController@update')->name('settings.union.update');
        Route::get('/union-list-by-upazila-id', 'UnionController@unionListByUpazilaId')->name('settings.union.list.upazila.id');
        Route::get('/union-delete/{id}', 'UnionController@destroy')->name('settings.union.destroy');
        Route::get('/union-status/{id}/{status}', 'UnionController@statusUpdate')->name('settings.union.status');
        //union operation end
        
        Route::get('/invoice', 'InvoiceController@invoice')->name('invoice');
        // Theam color
        Route::post('/theam_color', 'TheamColorController@store')->name('settings.theam.store');

    });
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Usermanage'], function () {
        //admin role operation start
        Route::get('/usermanage-userRole-list', 'UserRoleController@index')->name('usermanage.userRole.index');
        Route::get('/dataProcessingUserRole', 'UserRoleController@dataProcessinguserRole')->name('usermanage.userRole.dataProcessingRole');
        Route::get('/usermanage-userRole-create', 'UserRoleController@create')->name('usermanage.userRole.create');
        Route::post('/usermanage-userRole-store', 'UserRoleController@store')->name('usermanage.userRole.store');
        Route::get('/usermanage-userRole-edit/{id}', 'UserRoleController@edit')->name('usermanage.userRole.edit');
        Route::post('/usermanage-userRole-update/{id}', 'UserRoleController@update')->name('usermanage.userRole.update');
        Route::get('/usermanage-userRole-delete/{id}', 'UserRoleController@destroy')->name('usermanage.userRole.destroy');
        Route::get('/usermanage-userRole-status/{id}/{status}', 'UserRoleController@statusUpdate')->name('usermanage.userRole.status');
        //admin role operation end

        //user role operation start
        Route::get('/usermanage-user-list', 'UserController@index')->name('usermanage.user.index');
        Route::get('/dataProcessingUser', 'UserController@dataProcessinguser')->name('usermanage.user.dataProcessingUser');
        Route::get('/usermanage-user-create', 'UserController@create')->name('usermanage.user.create');
        Route::post('/usermanage-user-store', 'UserController@store')->name('usermanage.user.store');
        Route::get('/usermanage-user-edit/{id}', 'UserController@edit')->name('usermanage.user.edit');
        Route::post('/usermanage-user-update/{id}', 'UserController@update')->name('usermanage.user.update');
        Route::get('/usermanage-user-delete/{id}', 'UserController@destroy')->name('usermanage.user.destroy');
        Route::get('/usermanage-user-status/{id}/{status}', 'UserController@statusUpdate')->name('usermanage.user.status');
        //user role operation end

        //admin role operation start
        Route::get('/company-resource-list', 'CompanyResourceController@index')->name('company.resource.index');
        Route::get('/dataProcessingUserCompanyResource', 'CompanyResourceController@dataProcessinguserRole')->name('company.resource.dataProcessingCompanyResource');
        Route::get('/company-resource-create', 'CompanyResourceController@create')->name('company.resource.create');
        Route::post('/company-resource-store', 'CompanyResourceController@store')->name('company.resource.store');
        Route::get('/company-resource-edit/{id}', 'CompanyResourceController@edit')->name('company.resource.edit');
        Route::get('/company-resource-edit-ajax', 'CompanyResourceController@loadAjax')->name('company.resource.edit.ajax');
        Route::get('/company-resource-show/{id}', 'CompanyResourceController@show')->name('company.resource.show');
        Route::post('/company-resource-update/{id}', 'CompanyResourceController@update')->name('company.resource.update');
        Route::get('/company-resource-delete/{id}', 'CompanyResourceController@destroy')->name('company.resource.destroy');
        Route::get('/company-resource-status/{id}/{status}', 'CompanyResourceController@statusUpdate')->name('company.resource.status');
        //admin role operation end
    });
});


// Route::fallback(function() {
//     return response()->json([
//         'data' => [],
//         'success' => false,
//         'status' => 404,
//         'message' => 'Invalid Route'
//     ]);
// });