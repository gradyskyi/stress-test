<?php

use App\Jobs\ProcessPodcast;
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

Route::get('/make-fake-data', function (Request $request) {
    \App\Models\Product::factory()->count(2000)->create();
    return response()->json(['status' => 'ok']);
});

Route::get('/delete-fake-data', function (Request $request) {
    \App\Models\Product::query()->delete();
    return response()->json(['status' => 'ok']);
});

Route::get('/make-fake-user-data', function (Request $request) {
    \App\Models\User::factory()->count(10000)->create();
    return response()->json(['status' => 'ok']);
});

Route::get('/new-job', function (Request $request) {
    $jobsCount = 10000;
    $start_time = microtime(TRUE);
    for($i=0;$i<$jobsCount;$i++) {
        ProcessPodcast::dispatch();
    }
    $end_time = microtime(TRUE);

    return response()->json(['status' => 'ok', 'Jobs per s' => $jobsCount/($end_time - $start_time)]);
});