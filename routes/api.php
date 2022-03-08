<?php

use App\Http\Controllers\TodoController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(
    ['middleware' => []],
    function () {
        Route::group(
            ['prefix' => 'todos'],
            function () {
                Route::patch('complete/{todo}', [TodoController::class, 'complete']);
                Route::patch('incomplete/{todo}', [TodoController::class, 'incomplete']);
                Route::get('{todo}', [TodoController::class,'show']);
                Route::put('{todo}', [TodoController::class,'update']);
                Route::delete('{todo}', [TodoController::class,'show']);
                Route::get('', [TodoController::class,'index']);
            }
        );
    }
);
