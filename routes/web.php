<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::group(['middleware' => ['auth']], function () {

	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('employees', ['middleware' => ['permission:create'], 'uses' => 'EmployeeController@index'])->name('employees.index');
	Route::post('employees', ['middleware' => ['permission:create'], 'uses' => 'EmployeeController@store'])->name('employees.store');
	Route::get('employees/create', ['middleware' => ['permission:create'], 'uses' => 'EmployeeController@create'])->name('employees.create');
	Route::patch('employees/{employee}', ['middleware' => ['permission:edit'], 'uses' => 'EmployeeController@update'])->name('employees.update');
	Route::get('employees/{employee}/edit', ['middleware' => ['permission:edit'], 'uses' => 'EmployeeController@edit'])->name('employees.edit');
	Route::delete('employees/{employee}', ['middleware' => ['permission:delete'], 'uses' => 'EmployeeController@destroy'])->name('employees.destroy');

	Route::get('attachments/{employee}', ['middleware' => ['permission:create'], 'uses' => 'AttachmentController@index'])->name('attachments.index');
	Route::post('attachments', ['middleware' => ['permission:create'], 'uses' => 'AttachmentController@store'])->name('attachments.store');
	Route::get('attachments/{employee}/create', ['middleware' => ['permission:create'], 'uses' => 'AttachmentController@create'])->name('attachments.create');
	Route::patch('attachments/{attachment}', ['middleware' => ['permission:edit'], 'uses' => 'AttachmentController@update'])->name('attachments.update');
	Route::get('attachments/{attachment}/edit', ['middleware' => ['permission:edit'], 'uses' => 'AttachmentController@edit'])->name('attachments.edit');
	Route::delete('attachments/{attachment}', ['middleware' => ['permission:delete'], 'uses' => 'AttachmentController@destroy'])->name('attachments.destroy');
	Route::get('/uploads/{attachment}/attachments', ['middleware' => ['permission:edit'], 'uses' => 'AttachmentController@getDownload'])->name('dl_attachment');

	Route::get('grants', ['middleware' => ['permission:create'], 'uses' => 'GrantController@index'])->name('grants.index');
	Route::get('grants/overdue', ['middleware' => ['permission:create'], 'uses' => 'GrantController@overdueIndex'])->name('grants.overdueIndex');
	Route::post('grants', ['middleware' => ['permission:create'], 'uses' => 'GrantController@store'])->name('grants.store');
	Route::get('grants/create', ['middleware' => ['permission:create'], 'uses' => 'GrantController@create'])->name('grants.create');
	Route::patch('grants/{grant}', ['middleware' => ['permission:edit'], 'uses' => 'GrantController@update'])->name('grants.update');
	Route::get('grants/{grant}/edit', ['middleware' => ['permission:edit'], 'uses' => 'GrantController@edit'])->name('grants.edit');
	Route::delete('grants/{grant}', ['middleware' => ['permission:delete'], 'uses' => 'GrantController@destroy'])->name('grants.destroy');
	Route::get('/uploads/{grant}/grants', ['middleware' => ['permission:edit'], 'uses' => 'GrantController@getDownload'])->name('dl_grant');

	Route::get('grant_payments/{grant}', ['middleware' => ['permission:create'], 'uses' => 'GrantPaymentController@index'])->name('grant_payments.index');
	Route::post('grant_payments', ['middleware' => ['permission:create'], 'uses' => 'GrantPaymentController@store'])->name('grant_payments.store');
	Route::get('grant_payments/{grant}/create', ['middleware' => ['permission:create'], 'uses' => 'GrantPaymentController@create'])->name('grant_payments.create');
	Route::patch('grant_payments/{grant_payment}', ['middleware' => ['permission:edit'], 'uses' => 'GrantPaymentController@update'])->name('grant_payments.update');
	Route::get('grant_payments/{grant_payment}/edit', ['middleware' => ['permission:edit'], 'uses' => 'GrantPaymentController@edit'])->name('grant_payments.edit');
	Route::delete('grant_payments/{grant_payment}', ['middleware' => ['permission:delete'], 'uses' => 'GrantPaymentController@destroy'])->name('grant_payments.destroy');
	Route::get('/uploads/{grant_payment}/grant_payments', ['middleware' => ['permission:edit'], 'uses' => 'GrantPaymentController@getDownload'])->name('dl_grant_payment');

	Route::get('families/{employee}', ['middleware' => ['permission:create'], 'uses' => 'FamilyController@index'])->name('families.index');
	Route::post('families', ['middleware' => ['permission:create'], 'uses' => 'FamilyController@store'])->name('families.store');
	Route::get('families/{employee}/create', ['middleware' => ['permission:create'], 'uses' => 'FamilyController@create'])->name('families.create');
	Route::patch('families/{family}', ['middleware' => ['permission:edit'], 'uses' => 'FamilyController@update'])->name('families.update');
	Route::get('families/{family}/edit', ['middleware' => ['permission:edit'], 'uses' => 'FamilyController@edit'])->name('families.edit');
	Route::delete('families/{family}', ['middleware' => ['permission:delete'], 'uses' => 'FamilyController@destroy'])->name('families.destroy');
	Route::get('/uploads/{family}/families', ['middleware' => ['permission:edit'], 'uses' => 'FamilyController@getDownload'])->name('dl_family');

	Route::get('qualifications/{employee}', ['middleware' => ['permission:create'], 'uses' => 'QualificationController@index'])->name('qualifications.index');
	Route::post('qualifications', ['middleware' => ['permission:create'], 'uses' => 'QualificationController@store'])->name('qualifications.store');
	Route::get('qualifications/{employee}/create', ['middleware' => ['permission:create'], 'uses' => 'QualificationController@create'])->name('qualifications.create');
	Route::patch('qualifications/{qualification}', ['middleware' => ['permission:edit'], 'uses' => 'QualificationController@update'])->name('qualifications.update');
	Route::get('qualifications/{qualification}/edit', ['middleware' => ['permission:edit'], 'uses' => 'QualificationController@edit'])->name('qualifications.edit');
	Route::delete('qualifications/{qualification}', ['middleware' => ['permission:delete'], 'uses' => 'QualificationController@destroy'])->name('qualifications.destroy');
	Route::get('/uploads/{qualification}/qualifications', ['middleware' => ['permission:edit'], 'uses' => 'QualificationController@getDownload'])->name('dl_qualification');

	Route::get('disciplinaries/{employee}', ['middleware' => ['permission:create'], 'uses' => 'DisciplinaryController@index'])->name('disciplinaries.index');
	Route::post('disciplinaries', ['middleware' => ['permission:create'], 'uses' => 'DisciplinaryController@store'])->name('disciplinaries.store');
	Route::get('disciplinaries/{employee}/create', ['middleware' => ['permission:create'], 'uses' => 'DisciplinaryController@create'])->name('disciplinaries.create');
	Route::patch('disciplinaries/{disciplinary}', ['middleware' => ['permission:edit'], 'uses' => 'DisciplinaryController@update'])->name('disciplinaries.update');
	Route::get('disciplinaries/{disciplinary}/edit', ['middleware' => ['permission:edit'], 'uses' => 'DisciplinaryController@edit'])->name('disciplinaries.edit');
	Route::delete('disciplinaries/{disciplinary}', ['middleware' => ['permission:delete'], 'uses' => 'DisciplinaryController@destroy'])->name('disciplinaries.destroy');
	Route::get('/uploads/{disciplinary}/disciplinaries', ['middleware' => ['permission:edit'], 'uses' => 'DisciplinaryController@getDownload'])->name('dl_disciplinary');

	Route::get('allowances/{employee}', ['middleware' => ['permission:create'], 'uses' => 'AllowanceController@index'])->name('allowances.index');
	Route::post('allowances', ['middleware' => ['permission:create'], 'uses' => 'AllowanceController@store'])->name('allowances.store');
	Route::get('allowances/{employee}/create', ['middleware' => ['permission:create'], 'uses' => 'AllowanceController@create'])->name('allowances.create');
	Route::patch('allowances/{allowance}', ['middleware' => ['permission:edit'], 'uses' => 'AllowanceController@update'])->name('allowances.update');
	Route::get('allowances/{allowance}/edit', ['middleware' => ['permission:edit'], 'uses' => 'AllowanceController@edit'])->name('allowances.edit');
	Route::delete('allowances/{allowance}', ['middleware' => ['permission:delete'], 'uses' => 'AllowanceController@destroy'])->name('allowances.destroy');
	Route::get('/uploads/{allowance}/allowances', ['middleware' => ['permission:edit'], 'uses' => 'AllowanceController@getDownload'])->name('dl_allowance');

	Route::get('equipments/{employee}', ['middleware' => ['permission:create'], 'uses' => 'EquipmentController@index'])->name('equipments.index');
	Route::post('equipments', ['middleware' => ['permission:create'], 'uses' => 'EquipmentController@store'])->name('equipments.store');
	Route::get('equipments/{employee}/create', ['middleware' => ['permission:create'], 'uses' => 'EquipmentController@create'])->name('equipments.create');
	Route::patch('equipments/{equipment}', ['middleware' => ['permission:edit'], 'uses' => 'EquipmentController@update'])->name('equipments.update');
	Route::get('equipments/{equipment}/edit', ['middleware' => ['permission:edit'], 'uses' => 'EquipmentController@edit'])->name('equipments.edit');
	Route::delete('equipments/{equipment}', ['middleware' => ['permission:delete'], 'uses' => 'EquipmentController@destroy'])->name('equipments.destroy');
	Route::get('/uploads/{equipment}/equipments', ['middleware' => ['permission:edit'], 'uses' => 'EquipmentController@getDownload'])->name('dl_equipment');

	Route::get('reports', 'ImportExportController@reports')->name('reports');
	Route::get('exports', 'ImportExportController@employees')->name('reports.employees');
	Route::get('employeeDepartment', 'ImportExportController@employeeDepartment')->name('reports.employeeDepartment');
	Route::get('employeesGrant', 'ImportExportController@employeeGrant')->name('reports.employeesGrant');
	Route::get('employeesConfirm', 'ImportExportController@employeeConfirm')->name('reports.employeesConfirm');
	Route::get('employeesTermination', 'ImportExportController@employeeTermination')->name('reports.employeesTermination');
	Route::get('LongServices', 'ImportExportController@LongService')->name('reports.LongServices');
	Route::get('LocalForeigners', 'ImportExportController@LocalForeigner')->name('reports.LocalForeigners');
	Route::get('PassportExpires', 'ImportExportController@PassportExpire')->name('reports.PassportExpires');
	Route::get('EmployeesAge', 'ImportExportController@EmployeeAge')->name('reports.EmployeesAge');


	// Route::post('import', 'ImportExportController@import')->name('reports.import');

	Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
		Route::resource('roles','RoleController');
		Route::resource('users','UserController');

		Route::get('activities', 'ActivityController@index')->name('activities.index');

		Route::get('salaries/{employee}', ['middleware' => ['permission:salary'], 'uses' => 'SalaryController@index'])->name('salaries.index');
		Route::post('salaries', ['middleware' => ['permission:salary'], 'uses' => 'SalaryController@store'])->name('salaries.store');
		Route::get('salaries/{employee}/create', ['middleware' => ['permission:salary'], 'uses' => 'SalaryController@create'])->name('salaries.create');
		Route::patch('salaries/{salary}', ['middleware' => ['permission:salary'], 'uses' => 'SalaryController@update'])->name('salaries.update');
		Route::get('salaries/{salary}/edit', ['middleware' => ['permission:salary'], 'uses' => 'SalaryController@edit'])->name('salaries.edit');
		Route::delete('salaries/{salary}', ['middleware' => ['permission:salary'], 'uses' => 'SalaryController@destroy'])->name('salaries.destroy');
		Route::get('/uploads/{salary}/salaries', ['middleware' => ['permission:edit'], 'uses' => 'SalaryController@getDownload'])->name('dl_salary');
		});
});