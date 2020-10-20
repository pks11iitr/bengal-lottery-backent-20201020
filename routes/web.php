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
    return view('auth.my-login');
})->name('website.home');

Auth::routes();

Route::group(['middleware'=>['auth', 'acl']], function(){

    Route::group(['is'=>'admin'], function(){

    });

    Route::group(['is'=>'admin|subadmin'], function(){
    Route::get('/home', 'Portal\DashboardController@dashboard')->name('home');
    Route::get('/dashboard', 'Portal\DashboardController@dashboard')->name('dashboard');
    Route::get('/agents', 'Portal\AgentController@userslist')->name('agents');
    Route::post('create-agent', 'Portal\AgentController@createagent')->name('agentcreate');
    Route::get('agentdetails', 'Portal\AgentController@agentdetails')->name('agentdetails');
    Route::post('/agentupdate', 'Portal\AgentController@updateagent')->name('agentupdate');

    Route::get('list-game', 'Portal\GameController@index')->name('gamelist');
    Route::get('create-game', 'Portal\GameController@create')->name('creategame');
    Route::post('save-game', 'Portal\GameController@gamesave')->name('gamesave');


    Route::get('/products', 'Portal\ProductController@index')->name('products');

    Route::get('/product-list', 'Portal\ProductController@listing')->name('products.list');
    Route::get('/add-product', 'Portal\ProductController@addProductForm')->name('products.add');

    Route::get('/qr-codes', 'Portal\QRCodeController@index')->name('qrcodes');
    Route::get('/synced-products', 'Portal\ProductController@syncedProducts')->name('synced.products');

    Route::post('/add-product-store', 'Portal\ProductController@addProductStore')->name('products.addStore');
    Route::post('/edit-product-store', 'Portal\ProductController@editUpdate')->name('products.editUpdate');

    Route::post('/add-retrieve-product-store', 'Portal\ProductController@addRtrvProductStore')->name('products.addRtrvStore');
    Route::post('/edit-retrieve-product-store', 'Portal\ProductController@editRtrvUpdate')->name('products.editRtrvUpdate');


    Route::get('/profile', 'Portal\ProfileController@profile')->name('profile');
    Route::post('/profile-company-update', 'Portal\ProfileController@profileEditStore')->name('profile.company.update');
    Route::get('/profile#manufacturer', 'Portal\ProfileController@profile')->name('profileManufacturers');
    Route::post('/profile-manufacturer-add', 'Portal\ProfileController@manufacturerStore')->name('profileManufacturersAdd');
    Route::post('/profile-marketer-add', 'Portal\ProfileController@marketerStore')->name('profileMarketerAdd');
    Route::post('/profile-manufacturer-update', 'Portal\ProfileController@manufacturerEditStore')->name('profileManufacturersUpdate');
    Route::get('/profile-manufacturer-get/{id}', 'Portal\ProfileController@getManufactureDetails')->name('getManufactureDetails');
    Route::get('/profile#changePassword', 'Portal\ProfileController@profile')->name('profileChangePassword');
    Route::post('profile-change-password', 'Portal\ProfileController@changePasswordStore')->name('changePasswordStore');

    Route::get('product-detail-ajax', 'Portal\ProductController@productDetailAjax')->name('productDetailAjax');
    Route::get('retrieve-product-detail-ajax', 'Portal\ProductController@retrieveProductDetailAjax')->name('retrieveProductDetailAjax');
    Route::get('product-search', 'Portal\ProductController@productSearch')->name('productSearch');
    Route::get('license-search', 'Portal\ProductController@productSearchLicense')->name('productSearchLicense');

    Route::post('generate-code', 'Portal\QRCodeController@generatecode')->name('qrcodes.generate');
    Route::post('quick-generate-map', 'Portal\QRCodeController@generateNdMapCode')->name('qrcodes.generate.map');
    Route::post('map-codes', 'Portal\QRCodeController@mapCodes')->name('qrcodes.map');
    Route::get('mapped-codes', 'Portal\QRCodeController@mappedCodes')->name('mapped.codes');
    Route::post('sync-data', 'Portal\ProductController@syncProducts')->name('sync.products');

    Route::get('subscribe-now/{id}', 'Portal\PaymentController@subscribe')->name('subscribe.now');
    });
});


