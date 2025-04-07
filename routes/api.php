<?php

use App\Http\Controllers\api\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/exams', function (Request $request) {

    $fp = fopen('exams.json', 'w');
    fwrite($fp, json_encode(\App\Exam::all()));
    fclose($fp);

    return \App\Exam::all();
});

Route::middleware('api')->get('/sections', function (Request $request) {
    return \App\Section::all();
});

Route::middleware('api')->get('/fix', function (Request $request) {
    $ff = \App\Audio::where('file','like', '% %')->get();
	
	
	foreach($ff as $f) {
		$a = \App\Audio::find($f->id);
		$a->file = str_replace(' ', '_', $a->file);
		$a->save();
	}
	
	return 1;
});


// Route::post('login','LoginController@login');
Route::post('login',[LoginController::class,'login']);
Route::post('login2',[LoginController::class,'login2']);
Route::post('expiry_date',[LoginController::class,'expiry_date']);
Route::get('get-question',[LoginController::class,'question']);


