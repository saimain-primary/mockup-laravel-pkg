<?php

use Illuminate\Support\Facades\Route;
use Saimain\LaravelMockApi\Http\Controllers\Panel\MockResponseController;

Route::get('/', fn () => redirect()->route('mock-api.panel.mock-responses.index'));

Route::resource('mock-responses', MockResponseController::class)->except('show');
