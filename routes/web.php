<?php

Route::redirect('/', '/login');
Route::redirect('/home', '/admin');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    //Route::redirect('/', 'client');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Expensecategories
    Route::delete('expense-categories/destroy', 'ExpenseCategoryController@massDestroy')->name('expense-categories.massDestroy');
    Route::resource('expense-categories', 'ExpenseCategoryController');

    // Incomecategories
    Route::delete('income-categories/destroy', 'IncomeCategoryController@massDestroy')->name('income-categories.massDestroy');
    Route::resource('income-categories', 'IncomeCategoryController');

    // Expenses
    Route::delete('expenses/destroy', 'ExpenseController@massDestroy')->name('expenses.massDestroy');
    Route::resource('expenses', 'ExpenseController');

    // Incomes
    Route::delete('incomes/destroy', 'IncomeController@massDestroy')->name('incomes.massDestroy');
    Route::resource('incomes', 'IncomeController');

    // Expensereports
    Route::delete('expense-reports/destroy', 'ExpenseReportController@massDestroy')->name('expense-reports.massDestroy');
    Route::resource('expense-reports', 'ExpenseReportController');

    Route::resource('areas', 'AreaController');
    Route::resource('cost-center', 'Admin\CostCenterController');
    Route::resource('suppliers', 'Admin\SupplierController');
    Route::resource('client', 'Admin\ClientController');
    Route::resource('status', 'Admin\StatusController');


    Route::get('areas/create', 'AreaController@create')->name('areas.create');
});




Route::get('home_page', function () {
//echo 'Site under maintenance';
  return redirect()->route('dashboard.index');
})->name('home.index')->middleware('auth');

Route::get('dashboard/', 'Admin\DashboardController@index')->name('dashboard.index')->middleware('auth');

Route::get('dashboard_monthly', 'Admin\DashboardController@index_')->name('dashboard.monthly')->middleware('auth');


Route::get('dashboard/all-consumption', 'Admin\DashboardController@loadConsumptionByMonths')->name('dashboard.allconsumption')->middleware('auth');
Route::get('dashboard/area-consumption', 'Admin\DashboardController@loadAreaConsumption')->name('dashboard.areaconsumption')->middleware('auth');
Route::get('dashboard/all-income', 'Admin\DashboardController@loadAllIncome')->name('dashboard.income')->middleware('auth');
//Route::get('dashboard/all-income', 'Admin\DashboardController@loadAllIncome')->name('dashboard.income')->middleware('auth');

Route::get('dashboard/all-consumption_/{y}/{m}', 'Admin\DashboardController@loadConsumptionByMonths_')->name('dashboard.allconsumption_')->middleware('auth');
Route::get('dashboard/area-consumption_/{y}/{m}', 'Admin\DashboardController@loadAreaConsumption_')->name('dashboard.areaconsumption_')->middleware('auth');
Route::get('dashboard/all-income_/{y}/{m}', 'Admin\DashboardController@loadAllIncome_')->name('dashboard.income_')->middleware('auth');

Route::get('areas/', 'Admin\AreaController@index')->name('areas.index')->middleware('auth');
Route::post('areas/store', 'Admin\AreaController@store')->name('areas.store')->middleware('auth');
Route::get('areas/create', 'Admin\AreaController@create')->name('areas.create')->middleware('auth');
Route::get('areas/edit/{id}', 'Admin\AreaController@edit')->name('areas.edit')->middleware('auth');
Route::get('areas/show/{id}', 'Admin\AreaController@show')->name('areas.show')->middleware('auth');
Route::delete('areas/delete/{id}', 'Admin\AreaController@destroy')->name('areas.destroy')->middleware('auth');
Route::patch('areas/update/{id}', 'Admin\AreaController@update')->name('areas.update')->middleware('auth');

Route::get('cost-center/', 'Admin\CostCenterController@index')->name('cost-centers.index')->middleware('auth');
Route::post('cost-center/store', 'Admin\CostCenterController@store')->name('cost-centers.store')->middleware('auth');
Route::get('cost-center/create', 'Admin\CostCenterController@create')->name('cost-centers.create')->middleware('auth');
Route::get('cost-center/edit/{id}', 'Admin\CostCenterController@edit')->name('cost-centers.edit')->middleware('auth');
Route::get('cost-center/show/{id}', 'Admin\CostCenterController@show')->name('cost-centers.show')->middleware('auth');
Route::delete('cost-center/delete/{id}', 'Admin\CostCenterController@destroy')->name('cost-centers.destroy')->middleware('auth');
Route::patch('cost-center/update/{id}', 'Admin\CostCenterController@update')->name('cost-centers.update')->middleware('auth');


Route::get('suppliers/', 'Admin\SupplierController@index')->name('suppliers.index')->middleware('auth');
Route::post('suppliers/store', 'Admin\SupplierController@store')->name('suppliers.store')->middleware('auth');
Route::get('suppliers/create', 'Admin\SupplierController@create')->name('suppliers.create')->middleware('auth');
Route::get('suppliers/edit/{id}', 'Admin\SupplierController@edit')->name('suppliers.edit')->middleware('auth');
Route::get('suppliers/show/{id}', 'Admin\SupplierController@show')->name('suppliers.show')->middleware('auth');
Route::delete('suppliers/delete/{id}', 'Admin\SupplierController@destroy')->name('suppliers.destroy')->middleware('auth');
Route::patch('suppliers/update/{id}', 'Admin\SupplierController@update')->name('suppliers.update')->middleware('auth');

Route::get('legal-centers/', 'Admin\LegalCenterController@index')->name('legal-centers.index')->middleware('auth');
Route::post('legal-centers/store', 'Admin\LegalCenterController@store')->name('legal-centers.store')->middleware('auth');
Route::get('legal-centers/create', 'Admin\legalCenterController@create')->name('legal-centers.create')->middleware('auth');
Route::get('legal-centers/edit/{id}', 'Admin\LegalCenterController@edit')->name('legal-centers.edit')->middleware('auth');
Route::get('legal-centers/show/{id}', 'Admin\LegalCenterController@show')->name('legal-centers.show')->middleware('auth');
Route::delete('legal-centers/delete/{id}', 'Admin\LegalCenterController@destroy')->name('legal-centers.destroy')->middleware('auth');
Route::patch('legal-centers/update/{id}', 'Admin\LegalCenterController@update')->name('legal-centers.update')->middleware('auth');



Route::get('legal/create', 'Admin\LegalCenterController@legal')->name('legal.index')->middleware('auth');
Route::get('legal/new', 'Admin\LegalCenterController@new')->name('legal.new')->middleware('auth');
Route::post('legal/save', 'Admin\LegalCenterController@saveLegalCost')->name('legal.save')->middleware('auth');
Route::get('legal/delete/{id}', 'Admin\LegalCenterController@legalDelete')->name('legal.delete')->middleware('auth');


Route::get('clients/get', 'Admin\ClientController@loadClients')->name('get.clients')->middleware('auth');
Route::get('tenants/get', 'Admin\ClientController@loadTenants')->name('get.tenants')->middleware('auth');
Route::get('client/', 'Admin\ClientController@index')->name('client.index')->middleware('auth');
Route::get('tenant/', 'Admin\ClientController@tenants')->name('tenant.index')->middleware('auth');
Route::post('client/store', 'Admin\ClientController@store')->name('client.store')->middleware('auth');
Route::get('client/create', 'Admin\ClientController@create')->name('client.create')->middleware('auth');
Route::get('client/edit/{id}', 'Admin\ClientController@edit')->name('client.edit')->middleware('auth');
Route::get('client/show/{id}', 'Admin\ClientController@show')->name('client.show')->middleware('auth');
Route::delete('client/delete/{id}', 'Admin\ClientController@destroy')->name('client.destroy')->middleware('auth');
Route::patch('client/update/{id}', 'Admin\ClientController@update')->name('client.update')->middleware('auth');

Route::get('status/', 'Admin\StatusController@index')->name('status.index')->middleware('auth');
Route::post('status/store', 'Admin\StatusController@store')->name('status.store')->middleware('auth');
Route::get('status/create', 'Admin\StatusController@create')->name('status.create')->middleware('auth');
Route::get('status/edit/{id}', 'Admin\StatusController@edit')->name('status.edit')->middleware('auth');
Route::get('status/show/{id}', 'Admin\StatusController@show')->name('status.show')->middleware('auth');
Route::delete('status/delete/{id}', 'Admin\StatusController@destroy')->name('status.destroy')->middleware('auth');
Route::patch('status/update/{id}', 'Admin\StatusController@update')->name('status.update')->middleware('auth');


Route::get('sendText/{client_id}', 'Admin\MeterController@sendSampleText')->name('text.send')->middleware('auth');
Route::post('meter_reading', 'Admin\MeterController@meter_reading')->middleware('auth');
Route::post('sendNotification', 'Admin\MeterController@sendNotification')->middleware('auth')->name('SendSms');
Route::post('updateReadings', 'Admin\MeterController@updateReadings')->middleware('auth');

Route::get('meter/', 'Admin\MeterController@index')->name('meter.index')->middleware('auth');

Route::get('meter_reading_/{id}/{aid}', 'Admin\MeterController@register')->name('meter.reading.m')->middleware('auth');
Route::post('save_reading/{cid}/{id}/{aid}', 'Admin\MeterController@save_reading')->name('save.meter.reading')->middleware('auth');
Route::post('meter/store', 'Admin\MeterController@store')->name('meter.store')->middleware('auth');
Route::get('meter/create', 'Admin\MeterController@create')->name('meter.create')->middleware('auth');
Route::get('meter/edit/{id}', 'Admin\MeterController@edit')->name('meter.edit')->middleware('auth');
Route::get('meter/show/{id}', 'Admin\MeterController@show')->name('meter.show')->middleware('auth');
Route::delete('meter/delete/{id}', 'Admin\MeterController@destroy')->name('meter.destroy')->middleware('auth');
Route::patch('meter/update/{id}', 'Admin\MeterController@update')->name('meter.update')->middleware('auth');
Route::get('meter/change', 'Admin\MeterController@change')->name('meter.change')->middleware('auth');
Route::post('meter/change/post', 'Admin\MeterController@registerChange')->name('meter.change.post')->middleware('auth');
Route::post('schedule-cns/', 'Admin\MeterController@schedule_cns')->name('cns.index')->middleware('auth');
Route::get('scheduler/', 'Admin\MeterController@scheduler')->name('meter.scheduler')->middleware('auth');


Route::get('settings-nbrd/', 'Admin\SettingsNbrdController@index')->name('settings_nbrd.index')->middleware('auth');
Route::post('settings-nbrd/store', 'Admin\SettingsNbrdController@store')->name('settings_nbrd.store')->middleware('auth');
Route::get('settings-nbrd/create', 'Admin\SettingsNbrdController@create')->name('settings_nbrd.create')->middleware('auth');
Route::get('settings-nbrd/edit/{id}', 'Admin\SettingsNbrdController@edit')->name('settings_nbrd.edit')->middleware('auth');
Route::get('settings-nbrd/show/{id}', 'Admin\SettingsNbrdController@show')->name('settings_nbrd.show')->middleware('auth');
Route::delete('settings-nbrd/delete/{id}', 'Admin\SettingsNbrdController@destroy')->name('settings_nbrd.destroy')->middleware('auth');
Route::patch('settings-nbrd/update/{id}', 'Admin\SettingsNbrdController@update')->name('settings_nbrd.update')->middleware('auth');

Route::get('settings-dpm/', 'Admin\SettingsDpmController@index')->name('settings_dpm.index')->middleware('auth');
Route::post('settings-dpm/store', 'Admin\SettingsDpmController@store')->name('settings_dpm.store')->middleware('auth');
Route::get('settings-dpm/create', 'Admin\SettingsDpmController@create')->name('settings_dpm.create')->middleware('auth');
Route::get('settings-dpm/edit/{id}', 'Admin\SettingsDpmController@edit')->name('settings_dpm.edit')->middleware('auth');
Route::get('settings-dpm/show/{id}', 'Admin\SettingsDpmController@show')->name('settings_dpm.show')->middleware('auth');
Route::delete('settings-dpm/delete/{id}', 'Admin\SettingsDpmController@destroy')->name('settings_dpm.destroy')->middleware('auth');
Route::patch('settings-dpm/update/{id}', 'Admin\SettingsDpmController@update')->name('settings_dpm.update')->middleware('auth');

Route::get('billing/', 'Admin\TransactionController@index')->name('billing.index')->middleware('auth');
Route::get('billing/{id}/{aid}', 'Admin\TransactionController@register')->name('bill.reading')->middleware('auth');
Route::post('billing/{cid}/{id}/{aid}', 'Admin\TransactionController@save_reading')->name('save.bill.reading')->middleware('auth');
Route::post('billing/store', 'Admin\TransactionController@store')->name('bill.store')->middleware('auth');
Route::get('billing/create', 'Admin\TransactionController@create')->name('bill.create')->middleware('auth');
Route::get('billing/edit/{id}', 'Admin\TransactionController@edit')->name('bill.edit')->middleware('auth');
Route::get('billing/show/{id}', 'Admin\TransactionController@show')->name('bill.show')->middleware('auth');
Route::delete('billing/delete/{id}', 'Admin\TransactionController@destroy')->name('bill.destroy')->middleware('auth');
Route::patch('billing/update/{id}', 'Admin\TransactionController@update')->name('bill.update')->middleware('auth');



Route::get('lastRead/{id}', 'Admin\MeterController@loadLastReading')->name('last.reading')->middleware('auth');


Route::get('payment/', 'Admin\PaymentController@index')->name('payment.index')->middleware('auth');
Route::get('payment/{id}/{aid}', 'Admin\PaymentController@register')->name('payment.reading')->middleware('auth');
Route::post('payment/{cid}/{id}/{aid}', 'Admin\PaymentController@save_reading')->name('save.payment.reading')->middleware('auth');
Route::post('payment/store', 'Admin\PaymentController@store')->name('payment.store')->middleware('auth');
Route::get('payment/create', 'Admin\PaymentController@create')->name('payment.create')->middleware('auth');
Route::get('payment/edit/{id}', 'Admin\PaymentController@edit')->name('payment.edit')->middleware('auth');
Route::get('payment/show/{id}', 'Admin\PaymentController@show')->name('payment.show')->middleware('auth');
Route::delete('payment/delete/{id}', 'Admin\PaymentController@destroy')->name('payment.destroy')->middleware('auth');
Route::patch('payment/update/{id}', 'Admin\PaymentController@update')->name('payment.update')->middleware('auth');


Route::get('disconnected/bill', 'Admin\TransactionController@disconnected')->name('billing.disconnected')->middleware('auth');
Route::get('client/loadclient/{cid}', 'Admin\MeterController@getClientPage')->name('client.load')->middleware('auth');





Route::get('payment/adjustment', 'Admin\PaymentController@adjust')->name('payment.adjust')->middleware('auth');
Route::post('payment/store/adjustment', 'Admin\PaymentController@saveAdjustments')->name('payment.save.adjustment')->middleware('auth');


/* Route::get('payment/', 'Admin\PaymentController@index')->name('payment.index')->middleware('auth');
  Route::get('payment/{id}/{aid}', 'Admin\PaymentController@register')->name('payment.reading')->middleware('auth');
  Route::post('payment/{cid}/{id}/{aid}', 'Admin\PaymentController@save_reading')->name('save.payment.reading')->middleware('auth');
  Route::post('payment/store', 'Admin\PaymentController@store')->name('payment.store')->middleware('auth');
  Route::get('payment/create', 'Admin\PaymentController@create')->name('payment.create')->middleware('auth');
  Route::get('payment/edit/{id}', 'Admin\PaymentController@edit')->name('payment.edit')->middleware('auth');
  Route::get('payment/show/{id}', 'Admin\PaymentController@show')->name('payment.show')->middleware('auth');
  Route::delete('payment/delete/{id}', 'Admin\PaymentController@destroy')->name('payment.destroy')->middleware('auth');
  Route::patch('payment/update/{id}', 'Admin\PaymentController@update')->name('payment.update')->middleware('auth'); */


Route::get('bank/', 'Admin\BankController@index')->name('bank.index')->middleware('auth');
//Route::get('bank/{id}/{aid}', 'Admin\BankController@register')->name('bank.reading')->middleware('auth');
Route::post('bank/{cid}/{id}/{aid}', 'Admin\BankController@save_reading')->name('save.bank.reading')->middleware('auth');
Route::post('bank/store', 'Admin\BankController@store')->name('bank.store')->middleware('auth');
Route::get('bank/create', 'Admin\BankController@create')->name('bank.create')->middleware('auth');
Route::get('bank/edit/{id}', 'Admin\BankController@edit')->name('bank.edit')->middleware('auth');
Route::get('bank/show/{id}', 'Admin\BankController@show')->name('bank.show')->middleware('auth');
Route::delete('bank/delete/{id}', 'Admin\BankController@destroy')->name('bank.destroy')->middleware('auth');
Route::patch('bank/update/{id}', 'Admin\BankController@update')->name('bank.update')->middleware('auth');



Route::get('branch/', 'Admin\BranchController@index')->name('branch.index')->middleware('auth');
Route::get('branch/{bank}/{name}', 'Admin\BranchController@index')->name('bank.branch')->middleware('auth');
//Route::post('branch/{cid}/{id}/{aid}', 'Admin\BranchController@save_reading')->name('save.branch.reading')->middleware('auth');
Route::post('branch/store/{bank}/{name}', 'Admin\BranchController@store')->name('branch.store')->middleware('auth');
Route::get('branch/create/{bank}/{name}', 'Admin\BranchController@create')->name('branch.create')->middleware('auth');
Route::get('branch/edit/{id}/{bank}/{name}', 'Admin\BranchController@edit')->name('branch.edit')->middleware('auth');
Route::get('branch/show/{id}', 'Admin\BranchController@show')->name('branch.show')->middleware('auth');
Route::delete('branch/delete/{id}/{bank}/{name}', 'Admin\BranchController@destroy')->name('branch.destroy')->middleware('auth');
Route::patch('branch/update/{id}/{bank}/{name}', 'Admin\BranchController@update')->name('branch.update')->middleware('auth');


Route::get('mops/', 'Admin\MopController@index')->name('mops.index')->middleware('auth');
Route::post('mops/store', 'Admin\mopController@store')->name('mops.store')->middleware('auth');
Route::get('mops/create', 'Admin\mopController@create')->name('mops.create')->middleware('auth');
Route::get('mops/edit/{id}', 'Admin\MopController@edit')->name('mops.edit')->middleware('auth');
Route::get('mops/show/{id}', 'Admin\MopController@show')->name('mops.show')->middleware('auth');
Route::delete('mops/delete/{id}', 'Admin\mopController@destroy')->name('mops.destroy')->middleware('auth');
Route::patch('mops/update/{id}', 'Admin\MopController@update')->name('mops.update')->middleware('auth');


Route::get('invoice/', 'Admin\PaymentController@invoice')->name('invoicing.index')->middleware('auth');
Route::get('invoice/create', 'Admin\PaymentController@create_invoice')->name('invoicing.create')->middleware('auth');
Route::post('invoice/store', 'Admin\PaymentController@saveInvoice')->name('invoicing.store')->middleware('auth');
Route::get('invoice/show/{cid}/{ref}', 'Admin\PaymentController@showInvoice')->name('invoicing.show')->middleware('auth');
Route::get('invoice/delete/{ref}', 'Admin\PaymentController@deleteInvoice')->name('invoicing.delete')->middleware('auth');
Route::get('invoice/edit/{cid}/{ref}', 'Admin\PaymentController@editInvoice')->name('invoicing.edit')->middleware('auth');
Route::post('invoice/storeedit/{cid}/{ref}', 'Admin\PaymentController@saveInvoiceEdit')->name('invoicing.store_edit')->middleware('auth');
Route::post('invoice/savepayment', 'Admin\PaymentController@saveInvoicePayment')->name('invoicing.pay')->middleware('auth');
Route::post('invoice/savepayment', 'Admin\PaymentController@saveInvoicePayment')->name('invoicing.pay')->middleware('auth');
Route::get('invoice/deletepay/{id}/{ref}', 'Admin\PaymentController@deleteInvoiceMicro')->name('invoicing.delete_pay')->middleware('auth');
Route::get('invoice/loaddetails/{ref}', 'Admin\PaymentController@loadPaymentDetails')->name('invoicing.details')->middleware('auth');


Route::get('clients/print/{ref}', 'Admin\ClientController@createPDF')->name('clients.print')->middleware('auth');



Route::get('receipt', 'Admin\TransactionController@receipt')->name('receipt.index')->middleware('auth');
Route::get('run-bill', 'Admin\MeterController@runBill')->name('run.bill')->middleware('auth');
Route::get('bank-branches/{bank}', 'Admin\PaymentController@loadBranches')->name('bank.branches')->middleware('auth');
Route::get('client-info/{pid}/{client_id}', 'Admin\PaymentController@loadClientInformation')->name('client.info')->middleware('auth');
Route::get('client-info-receipt/{pid}/{client_id}', 'Admin\ReceiptController@index')->name('client.receipt')->middleware('auth');

Route::get('receipt', 'Admin\TransactionController@receipt')->name('receipt.index')->middleware('auth');

Route::get('find_id/{id}', 'Admin\MeterController@getFid')->name('find.id')->middleware('auth');

Route::get('reading_sheet/{area_id}', 'Admin\MeterController@load_sheet')->name('reading.sheet')->middleware('auth');
Route::get('download_sheet/{area_id}', 'Admin\MeterController@download_sheet')->name('download.sheet')->middleware('auth');


Route::get('statement/{start}/{end}', 'Admin\TransactionController@statement')->name('statement.index')->middleware('auth');
Route::post('get-statement', 'Admin\TransactionController@get')->name('statement.get')->middleware('auth');
Route::get('statement/print', 'Admin\TransactionController@createPDF')->middleware('auth');

Route::get('ut', 'UsersController@index')->middleware('auth');

Route::post('disconnect_client', 'Admin\MeterController@disconnect')->name('client.disconnect')->middleware('auth');
Route::post('reconnect_client', 'Admin\MeterController@reconnect')->name('client.reconnect')->middleware('auth');

Route::get('avatar/{id}', 'Admin\ClientController@avatar')->name('client.avatar')->middleware('auth');
Route::get('receipt/{id}', 'Admin\ReceiptController@index')->name('receipt')->middleware('auth');

Route::get('receipt/create/new', 'Admin\ReceiptController@create')->name('receipt-create')->middleware('auth');

Route::get('client-last-info/{id}', 'Admin\MeterController@loadlast')->name('client.latest')->middleware('auth');

Route::get('notification/{id}/{date}', 'Admin\MeterController@notification_center')->name('notification.index')->middleware('auth');



Route::get('point', 'Admin\AreaController@generateReferral')->name('point')->middleware('auth');


//Route::get('meter/changes', 'Admin\MeterController@changes')->name('mchanges')->middleware('auth');

Route::get('r/area', 'Admin\ReportController@areas')->name('r.area')->middleware('auth');
Route::get('r/people', 'Admin\ReportController@people')->name('r.people')->middleware('auth');


/* Reports */
Route::get('waterbill', 'Admin\ReportController@waterbill')->name('waterbill')->middleware('auth');
Route::get('waterbilla', 'Admin\ReportController@waterbillbyaccount')->name('waterbilla')->middleware('auth');
Route::get('billLoader', 'Admin\ReportController@billLoader')->name('billLoader')->middleware('auth');

Route::get('balances', 'Admin\ReportController@balances')->name('balances')->middleware('auth');

Route::get('balances/client', 'Admin\ReportController@balances_client')->name('client.balances')->middleware('auth');
Route::get('clients/with-balances', 'Admin\ReportController@clients_with_balances')->name('client.with_balances')->middleware('auth');
Route::get('clients/with-no-balances', 'Admin\ReportController@clients_with_no_balances')->name('client.with_no_balances')->middleware('auth');

Route::get('history', 'Admin\ReportController@history')->name('reading.history')->middleware('auth');
Route::get('sales/revenue', 'Admin\ReportController@sales_revenue')->name('sales.revenue')->middleware('auth');
Route::get('reading/sheets', 'Admin\ReportController@reading_sheets')->name('reading.sheets')->middleware('auth');
Route::get('no_water_debits', 'Admin\ReportController@no_water_debits')->name('no.water.debits')->middleware('auth');
Route::post('no-water-debits-post', 'Admin\ReportController@no_water_debit_post')->name('no.water.debits.post')->middleware('auth');
Route::get('areas/report', 'Admin\ReportController@area_report')->name('area.report')->middleware('auth');
Route::get('meter/changes', 'Admin\ReportController@meter_changes')->name('meter.changes')->middleware('auth');
Route::get('meter/history', 'Admin\ReportController@history_report')->name('meter.history')->middleware('auth');
Route::get('income/expenditure', 'Admin\ReportController@income_expenditure')->name('income.expenditure')->middleware('auth');



Route::get('/logout-user', function () {
    Auth::logout();
    return Redirect::to('login');
})->middleware('auth');



Route::group(['prefix' => 'api/v1'], function () {
    Route::get('/', 'Api\ApiController@index');
    Route::get('clients', 'Api\ApiController@loadClients');
    Route::get('client/{area}', 'Admin\MeterController@loadClient');
    Route::post('save_meter', 'Api\ApiController@save_reading');
    Route::get('area_clients/{area_id}', 'Api\ApiController@loadClientsByArea');
});

Route::group(['prefix' => 'api/payment'], function () {
    Route::get('test', function () {
        echo phpinfo();
    });
    Route::get('register-urls', 'MpesaController@registerURLs');

    Route::get('payment-url', 'MpesaController@simulate');
    Route::get('test-url', 'MpesaController@simulate1');
});


Route::get('confirmation', 'MpesaController@c2bConfirmationCallback');
Route::post('validation', 'MpesaController@c2bValidationCallback');

Route::get('/mobile_transactions', 'Admin\PaymentController@paybills')->name('mobile_transactions.index')->middleware('auth');
Route::get('/mobile_transactions_stray', 'Admin\PaymentController@paybills_stray')->name('mobile_transactions.stray')->middleware('auth');
Route::get('/mobile_transactions/search', 'Admin\PaymentController@search')->name('transactions.search')->middleware('auth'); 
Route::get('/mobile_transactions_stray', 'Admin\PaymentController@paybills_stray')->name('mobile_transactions.stray')->middleware('auth');
Route::get('/all_clients', 'Admin\PaymentController@getClients')->name('all.clients')->middleware('auth'); 


Route::post('/reconcile_save', 'Admin\PaymentController@save_payment_modified')->name('reconcile.save')->middleware('auth');

Route::get('/sms/{client_id}/{amount}', 'Admin\PaymentController@sendBalance')->name('sms.payment.send');

Route::get('/updateRents', 'Jobs\JobController@updateClientRents')->name('jobs.update.rents');

Route::get('/runBills', 'Jobs\JobController@runBills')->name('jobs.run.bills');
