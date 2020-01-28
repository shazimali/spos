<?php

//Auth
Route::get('/','AuthController@login')->name('login');
Route::post('/login','AuthController@postlogin')->name('post-login');
Route::post('logout','AuthController@logout');


Route::group(['middleware' =>'auth'], function () {

    //Dashboard
    Route::get('/dashboard','HomeController@index')->name('dashboard');
    Route::get('/all-customers','HomeController@customers');
    Route::get('/all-products','HomeController@products');


    //users
    Route::get('/user','UserController@index')->name('user');
    Route::get('/user/create','UserController@create')->middleware(['permission:create_user']);
    Route::post('/user/store','UserController@store')->middleware(['permission:create_user']);
    Route::get('/user/edit/{id}','UserController@edit')->middleware(['permission:edit_user']);
    Route::post('/user/update/{id}','UserController@update')->middleware(['permission:edit_user']);
    Route::delete('/user/delete/{id}','UserController@destroy')->middleware(['permission:delete_user']);


    //Roles
    Route::get('/role','RoleController@index')->name('role');
    Route::get('/role/create','RoleController@create')->middleware(['permission:create_role']);
    Route::post('/role/store','RoleController@store')->middleware(['permission:create_role']);
    Route::get('/role/edit/{id}','RoleController@edit')->middleware(['permission:edit_role']);
    Route::put('/role/update/{id}','RoleController@update')->middleware(['permission:edit_role']);
    Route::delete('/role/delete/{id}','RoleController@destroy')->middleware(['permission:delete_role']);


//suppliers

    Route::get('suppliers','SupplierController@index');
    Route::post('suppliers','SupplierController@store');
    Route::put('suppliers/{id}/edit','SupplierController@update');
    Route::delete('/suppliers/{id}','SupplierController@destroy');
    Route::get('/all-suppliers',"SupplierController@allSuppliers");

//products head

    Route::get('/products-head','ProductHeadController@index');
    Route::post('/products-head','ProductHeadController@store');
    Route::put('/products-head/{id}/edit','ProductHeadController@update');
    Route::delete('/products-head/{id}','ProductHeadController@destroy');

//purchasing

    Route::get('purchase','PurchaseController@index');
    Route::post('purchase','PurchaseController@store');
    Route::put('purchase/{id}','PurchaseController@update');
    Route::get('purchase-get-suppliers','PurchaseController@getSuppliers');
    Route::get('purchase-get-suppliers/{id}/edit','PurchaseController@getSuppliers');
    Route::get('purchase-create','PurchaseController@create');
    Route::get('purchase/{id}/edit','PurchaseController@edit');
    Route::get('purchase/{id}/show','PurchaseController@show');

//purchase return

    Route::get('purchase-return','ReturnPurchaseController@create');
    Route::post('purchase-return','ReturnPurchaseController@store');
    Route::get('purchase-return-list','ReturnPurchaseController@index');
    Route::get('purchase-return/{id}/edit','ReturnPurchaseController@edit');
    Route::put('purchase-return/{id}','ReturnPurchaseController@update');


//stock

    Route::get('stock','StockController@index');

//customers

    Route::get('customers','CustomerController@index');
    Route::post('customers','CustomerController@store');
    Route::put('customers/{id}/edit','CustomerController@update');
    Route::delete('customers/{id}','CustomerController@destroy');

//sales

    Route::get('sales','SaleController@index');
    Route::post('sales','SaleController@store');
    Route::get('sales-get-customers','SaleController@getCustomers');
    Route::post('sales-get-products','SaleController@getProducts');
    Route::get('sales-create','SaleController@create');
    Route::delete('sales/{id}','SaleController@destroy');
    Route::get('sales-get-customers/{id}/edit','SaleController@getCustomers');
    Route::get('sales/{id}/edit','SaleController@edit');
    Route::put('sales/{id}','SaleController@update');
    Route::get('sale/{id}/show','SaleController@show')->name('sale-inovice-print');


    //return sale
    Route::get('sales-return','ReturnSaleController@create');
    Route::post('sales-return','ReturnSaleController@store');
    Route::get('sales-return-list','ReturnSaleController@index');
    Route::get('sales-return/{id}/edit','ReturnSaleController@edit');
    Route::put('sales-return/{id}','ReturnSaleController@update');

    //Expense Head
    Route::get('/expense-head','ExpenseHeadController@index')->name('expense-head');
    Route::post('/expense-head/store','ExpenseHeadController@store');
    Route::put('/expense-head/update/{id}','ExpenseHeadController@update');

    //Expense
    Route::get('/expense','ExpenseController@index')->name('expense');
    Route::get('/expense/create','ExpenseController@create');
    Route::post('/expense/store','ExpenseController@store');
    Route::get('/expense/edit/{id}','ExpenseController@edit');
    Route::put('/expense/update/{id}','ExpenseController@update');

    //Profit Loss
    Route::get('/customer-profit-loss','ProfitLossController@customer')->name('customer-profit-loss');
    Route::get('/customer-profit-loss/search','ProfitLossController@customerSearch');

    Route::get('/product-profit-loss','ProfitLossController@product')->name('product-profit-loss');
    Route::get('/product-profit-loss/search','ProfitLossController@productSearch');


    //CustomerVoucher
    Route::get('/customer-voucher','CustomerVoucherController@index')->name('customer-voucher');
    Route::post('/customer-voucher/store','CustomerVoucherController@store');
    Route::get('/customer-balance/{id}','CustomerVoucherController@getCustomerBalance');
    Route::put('/customer-voucher/update/{id}','CustomerVoucherController@update');

    //SupplierVoucher
    Route::get('/supplier-voucher','SupplierVoucherController@index')->name('customer-voucher');
    Route::post('/supplier-voucher/store','SupplierVoucherController@store');
    Route::get('/supplier-balance/{id}','SupplierVoucherController@getSupplierBalance');
    Route::put('/supplier-voucher/update/{id}','SupplierVoucherController@update');

    //Customer Ledgers
    Route::get('/customer-ledger','LedgerController@customer');
    Route::get('/customer-ledger/search','LedgerController@customerSearch');
    Route::get('customer-ledger/show','LedgerController@customerShow')->name('customer-ledger-print');

    //Customer Ledgers
    Route::get('/supplier-ledger','LedgerController@supplier');
    Route::get('/supplier-ledger/search','LedgerController@supplierSearch');
    Route::get('supplier-ledger/show','LedgerController@supplierShow')->name('supplier-ledger-print');

    //Product Ledger
    Route::get('/product-ledger','LedgerController@product');
    Route::get('/product-ledger/search','LedgerController@productSearch');
    Route::get('product-ledger/show','LedgerController@productShow')->name('product-ledger-print');

    //Day Book
    Route::get('/day-book','LedgerController@dayBook');
    Route::get('/day-book/search','LedgerController@dayBookSearch');
    Route::get('day-book/show','LedgerController@dayBookShow')->name('daybook-ledger-print');

    //Tax

    Route::get('/all-taxes','TaxController@index');
});
