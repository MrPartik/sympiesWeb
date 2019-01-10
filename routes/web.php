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


Auth::routes();

//error page
Route::get('/400',function(){
    return view('errorPage.400');
});
Route::get('/product/export','ProductPageController@export');

Route::get('/shop',function(){
    $prodInfo = App\r_product_info::with('rAffiliateInfo','rProductType','rTaxTableProfile')->get();
    return view('shop.index',compact('prodInfo'));
});


Route::resource('/','CartPageController', ['names' => ['index' => 'Welcome',]]);
Route::get('/cart/view','CartPageController@view_cart')->name('Cart');

Route::post('/product/actDeact','ProductPageController@actDeact');
Route::post('/tax/actDeact','TaxPageController@actDeact');
Route::post('/affiliate/actDeact','UsersAffiliatePageController@actDeact');
Route::post('/category/actDeact','ProdCategoryPageController@actDeact');

Route::post('/product/appDisapprove','ProductPageController@appDisapprove');

Route::post('/product/ProductVar','ProductPageController@ProductVar');
Route::get('/product/showProductVar/{id}','ProductPageController@showProductVar');
Route::post('/product/deleteAllProductVar','ProductPageController@deleteAllProductVar');

Route::get('/product/showInfo/{id}','ProductPageController@showProduct');

Route::post('/cart/add/{id}','CartPageController@addToCart');

Route::group(['middleware' => ['member']], function (){
    Route::get('/member', function () {return view('member.dashboard.index');})->name('Member');
    Route::get('member/dashboard', function () {return view('member.dashboard.index');})->name('Dashboard');
    Route::resource('member/shop/product','ProductPageController', ['names' => ['index' => 'Product',]]);
});

Route::group(['middleware' => ['admin']], function () {
    Route::get('admin/dashboard', function () {return view('admin.dashboard.index');})->name('Dashboard');
    Route::get('admin/inventory/remaining','InventoryPageController@remaining')->name('Remaining Inventory');
    Route::get('admin/inventory/history','InventoryPageController@index')->name('History Inventory');
    Route::get('admin/shop/ledger', function () {return view('admin.ledger.index');})->name('Ledger');
    Route::resource('admin/inventory/add','InventoryPageController',['names' => ['index' => 'Add Inventory','show'=>'History Inventory']]);
    Route::get('admin/shop/customer', function () {return view('admin.customer.index');})->name('Customer');
    Route::resource('admin/shop/product','ProductPageController',['names' => ['index' => 'Product',]]);
    Route::resource('admin/shop/tax','TaxPageController',['names' => ['index' => 'Tax',]]);
    Route::resource('admin/shop/category','ProdCategoryPageController',['names' => ['index' => 'Product Category',]]);
    Route::resource('admin/shop/subcategory','ProdCategoryPageController',['names' => ['index' => 'Product Sub-Category',]]);

    Route::resource('admin/users/affiliate','UsersAffiliatePageController',['names' => ['index' => 'Affiliates Management',]]);
    Route::resource('admin/users/manage','UsersManagementPageController',['names' => ['index' => 'User Management',]]);
    Route::get('admin/users/track', function () {return view('admin.users.track');})->name('Track Users');

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
