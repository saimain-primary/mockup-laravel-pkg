<?php

use Illuminate\Support\Facades\Route;
use Saimain\LaravelMockApi\Http\Controllers\MockApiController;

Route::any('{path}', MockApiController::class)->where('path', '.*');
