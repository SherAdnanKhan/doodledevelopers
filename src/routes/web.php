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

use Illuminate\Support\Facades\Route;

Route::get('/docs', function () {
    return view('docs.doc');
});

/*
 * WEBHOOKS
 */
Route::prefix('webhooks')->group(function(){
    Route::post('zing', 'Webhooks\ZingWebhook@store');
    Route::get('zing', function() {
        return "success";
    });
});
