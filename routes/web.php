<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;

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

 
Route::group(['middleware' => ['auth']], function() {
    Route::get('/', 'App\Http\Controllers\DashbourdController@index');
    Route::get('/dashboard', 'App\Http\Controllers\DashbourdController@index');
    Route::get('/createpro-index', 'App\Http\Controllers\DashbourdController@create_index')->name('createpro-index');
    Route::get('/headpurchese-index', 'App\Http\Controllers\DashbourdController@index');
    Route::get('/chose-base', 'App\Http\Controllers\SessionController@set_choose_base')->name('chose-base');
    Route::get('/load-group-sub', 'App\Http\Controllers\ApiController@load_sub_group')->name('load-group-sub');
    Route::get('/load-group-sub2', 'App\Http\Controllers\ApiController@load_sub_group2')->name('load-group-sub2');
    
    Route::get('/product-brand', 'App\Http\Controllers\ManageData\ProductBrandController@index')->name('product-brand');
    Route::post('/load-cate-brand', 'App\Http\Controllers\ManageData\ProductBrandController@load_cate_brand')->name('load-cate-brand');
    Route::post('/load-brand', 'App\Http\Controllers\ManageData\ProductBrandController@load_brand')->name('load-brand');
    Route::post('/save-cate-brand', 'App\Http\Controllers\ManageData\ProductBrandController@insert_cate_brand')->name('save-cate-brand');
    Route::post('/delete-cate-brand', 'App\Http\Controllers\ManageData\ProductBrandController@delete_cate_brand')->name('delete-cate-brand');

    Route::get('/product-pattern', 'App\Http\Controllers\ManageData\ProductPatternController@index')->name('product-pattern');
    Route::post('/load-cate-pattern', 'App\Http\Controllers\ManageData\ProductPatternController@load_cate_pattern')->name('load-cate-pattern');
    Route::post('/load-pattern', 'App\Http\Controllers\ManageData\ProductPatternController@load_pattern')->name('load-pattern');
    Route::post('/save-cate-pattern', 'App\Http\Controllers\ManageData\ProductPatternController@insert_cate_pattern')->name('save-cate-pattern');
    Route::post('/delete-cate-pattern', 'App\Http\Controllers\ManageData\ProductPatternController@delete_cate_pattern')->name('delete-cate-pattern');

    Route::get('/product-size', 'App\Http\Controllers\ManageData\ProductSizeController@index')->name('product-size');
    Route::post('/load-cate-size', 'App\Http\Controllers\ManageData\ProductSizeController@load_cate_size')->name('load-cate-size');
    Route::post('/load-size', 'App\Http\Controllers\ManageData\ProductSizeController@load_size')->name('load-size');
    Route::post('/save-cate-size', 'App\Http\Controllers\ManageData\ProductSizeController@insert_cate_size')->name('save-cate-size');
    Route::post('/delete-cate-size', 'App\Http\Controllers\ManageData\ProductSizeController@delete_cate_size')->name('delete-cate-size');

    Route::get('/product-design', 'App\Http\Controllers\ManageData\ProductDesignController@index')->name('product-design');
    Route::post('/load-cate-design', 'App\Http\Controllers\ManageData\ProductDesignController@load_cate_design')->name('load-cate-design');
    Route::post('/load-design', 'App\Http\Controllers\ManageData\ProductDesignController@load_design')->name('load-design');
    Route::post('/save-cate-design', 'App\Http\Controllers\ManageData\ProductDesignController@insert_cate_design')->name('save-cate-design');
    Route::post('/delete-cate-design', 'App\Http\Controllers\ManageData\ProductDesignController@delete_cate_design')->name('delete-cate-design');
 
    Route::post('/load-brand-pattern-size-design', 'App\Http\Controllers\PurchasingController@load_brand_pattern_size_design')->name('load-brand-pattern-size-design');
    Route::post('/load-wh-self', 'App\Http\Controllers\PurchasingController@load_wh_self')->name('load-wh-self'); 
    Route::post('/save-purchasing', 'App\Http\Controllers\PurchasingController@save_purchasing')->name('save-purchasing');
    Route::post('/save-purchasing-product', 'App\Http\Controllers\PurchasingController@save_pur_product')->name('save-purchasing-product');
    Route::post('/delete-purchasing', 'App\Http\Controllers\PurchasingController@delete_purchasing')->name('delete-purchasing');
    Route::get('/load-purchasing', 'App\Http\Controllers\PurchasingController@load_data')->name('load-purchasing');
    Route::post('/delete-purchasing-inventory', 'App\Http\Controllers\PurchasingController@delete_purchasing_inventory')->name('delete-purchasing-inventory');
    
    Route::get('/show-inventory/{doc_no?}/{code?}', 'App\Http\Controllers\PurchasingController@show_purchasing_inventory');
    Route::get('/edit-inventory/{doc_no?}/{code?}', 'App\Http\Controllers\PurchasingController@edit_purchasing_inventory');
    Route::post('/edit-purchasing-product', 'App\Http\Controllers\PurchasingController@edit_pur_product')->name('edit-purchasing-product');
    Route::post('/confirm-for-check-purchasing', 'App\Http\Controllers\PurchasingController@confirm_for_check_purchasing')->name('confirm-for-check-purchasing');

    Route::get('/load-purchasing-for-check', 'App\Http\Controllers\CheckPurchasingController@load_data')->name('load-purchasing-for-check');
    Route::post('/send-purchase-back-edit', 'App\Http\Controllers\CheckPurchasingController@send_back_for_edit')->name('send-purchase-back-edit');
    Route::post('/confirm-approve-purchasing', 'App\Http\Controllers\CheckPurchasingController@confirm_approve_purchasing')->name('confirm-approve-purchasing');
    Route::get('/approve-inventory/{doc_no?}', 'App\Http\Controllers\CheckPurchasingController@approve_purchasing_inventory')->name('approve-inventory');
    
    Route::get('/load-purchasing-for-upload', 'App\Http\Controllers\UploadPurchaseController@load_data')->name('load-purchasing-for-upload');
    Route::post('/send-purchase-to-accounting', 'App\Http\Controllers\CheckPurchasingController@send_purchasing_to_accounting')->name('send-purchase-to-accounting');

    Route::get('/load-purchasing-for-join-account', 'App\Http\Controllers\AccountingController@load_data')->name('load-purchasing-for-join-account');
    Route::get('/load-chat-of-account', 'App\Http\Controllers\AccountingController@load_chat_of_account')->name('load-chat-of-account');
    Route::post('/add-chat-of-account-to-pur', 'App\Http\Controllers\AccountingController@add_chat_account_to_pur')->name('add-chat-of-account-to-pur');
    Route::post('/confirm-join-accounting', 'App\Http\Controllers\AccountingController@confirm_add_account')->name('confirm-join-accounting');

    Route::post('/upload-purchasing-product', 'App\Http\Controllers\UploadPurchaseController@upload_data')->name('upload-purchasing-product');
    Route::post('/load-invent-code', 'App\Http\Controllers\PurchasingController@create_code')->name('load-invent-code');
    
    Route::get('/product-category', 'App\Http\Controllers\ManageData\ProductCategory@index')->name('product-category');
    Route::post('/load-product-cate', 'App\Http\Controllers\ManageData\ProductCategory@load_product_category')->name('load-product-cate');
    Route::post('/load-category', 'App\Http\Controllers\ManageData\ProductCategory@load_category')->name('load-category');
    Route::post('/save-product-cate', 'App\Http\Controllers\ManageData\ProductCategory@insert_product_category')->name('save-product-cate');
    Route::post('/delete-product-cate', 'App\Http\Controllers\ManageData\ProductCategory@delete_product_category')->name('delete-product-cate');

    Route::get('/products', 'App\Http\Controllers\ManageData\ProductController@index')->name('products');
    Route::post('/load-product', 'App\Http\Controllers\ManageData\ProductController@load_product')->name('load-product');
    Route::post('/save-product', 'App\Http\Controllers\ManageData\ProductController@insert_product')->name('save-product');
    Route::post('/delete-product', 'App\Http\Controllers\ManageData\ProductController@delete_product')->name('delete-product');
    Route::post('/edit-product', 'App\Http\Controllers\ManageData\ProductController@edit_product')->name('edit-product');

    Route::get('/group-warehouse', 'App\Http\Controllers\ManageData\GroupWarehouseController@index')->name('group-warehouse');
    Route::post('/load-group-wh', 'App\Http\Controllers\ManageData\GroupWarehouseController@load_group_wh')->name('load-group-wh');
    Route::post('/load-warehouse', 'App\Http\Controllers\ManageData\GroupWarehouseController@load_warehouse')->name('load-warehouse');
    Route::post('/save-group-wh', 'App\Http\Controllers\ManageData\GroupWarehouseController@insert_group_wh')->name('save-group-wh');
    Route::post('/delete-group-wh', 'App\Http\Controllers\ManageData\GroupWarehouseController@delete_group_wh')->name('delete-group-wh');

    Route::get('/report-product-uploaded', 'App\Http\Controllers\ReportController@report_product_uploaded')->name('report-product-uploaded');
    Route::get('/report-new-product', 'App\Http\Controllers\ReportController@report_new_product')->name('report-new-product');
    Route::get('/show-product-upload/{doc_no?}', 'App\Http\Controllers\ReportController@show_product_uploaded');
    Route::post('/load-data-detail', 'App\Http\Controllers\ReportController@load_data_print')->name('load-data-detail');

 
    Route::get('/brands-index', 'App\Http\Controllers\BrandsController@index')->name('brands-index');
    Route::get('/brands-create', 'App\Http\Controllers\BrandsController@create')->name('brands-create');
    Route::post('/brands-save', 'App\Http\Controllers\BrandsController@save')->name('brands-save');
    Route::get('/brands-edit/{code}', 'App\Http\Controllers\BrandsController@edit')->name('brands-edit');

    ///spec 
    Route::get('/spec-index/{item_code}', 'App\Http\Controllers\SpecController@spec_index')->name('spec-index');
    Route::post('/spec-save', 'App\Http\Controllers\SpecController@spec_save');

    //arrtibute
    Route::get('/attribute-index/{cat_id}/{cat_name}', 'App\Http\Controllers\SpecController@attribute_index')->name('attribute-index');
    Route::get('/category', 'App\Http\Controllers\SpecController@category_list')->name('category');
    Route::get('/category-index', 'App\Http\Controllers\SpecController@category_index')->name('category-index');
    Route::post('/attribute-save', 'App\Http\Controllers\SpecController@save_attribute')->name('attribute-save');

    Route::get('/import-index', 'App\Http\Controllers\SpecController@import_index')->name('import-index');
    Route::get('/spec-export', 'App\Http\Controllers\SpecController@export')->name('spec.export');
    Route::post('/spec-import', 'App\Http\Controllers\SpecController@import')->name('spec.import');


    //// ອັບສິນຄ້າລະຫວ່າງກັນ ////
    Route::get('/uploadpro-index', 'App\Http\Controllers\MasterdataController@index')->name('uploadpro-index');
    Route::get('/inventory/list', 'App\Http\Controllers\MasterdataController@product_list')->name('inventory.list');
    Route::post('/inventory/upload', 'App\Http\Controllers\MasterdataController@product_upload')->name('inventory.upload');



    ////// ການປ່ຽນຊື່ສິນຄ້າໃນລະບົບ /////
    Route::get('/changename-index', 'App\Http\Controllers\ChangenameProduct@index')->name('changename-index');
}); 

//route for admin
Route::group(['middleware' => ['auth', 'role:superadministrator']], function() {
    Route::resource('employee', 'App\Http\Controllers\EmployeeController');
}); 


require __DIR__.'/auth.php';