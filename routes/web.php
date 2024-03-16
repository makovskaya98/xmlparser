<?php

use App\Http\Controllers\OffersController;
use App\Jobs\xmlHandlerJob;
use App\Models\Feeds;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\XmlController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', XmlController::class)->name('main');

Route::post('/', [XmlController::class, 'createFeedUrl']);

Route::apiResource('api/offers', OffersController::class);
