<?php

use Illuminate\Support\Facades\Route;
use Saimain\LaravelMockApi\Http\Controllers\Panel\MockResponseController;

Route::get('/', fn () => redirect()->route('mock-api.panel.mock-responses.create'));

Route::resource('mock-responses', MockResponseController::class)->except('show');

Route::get('docs', [MockResponseController::class, 'docsIndex'])->name('docs.index');
Route::get('docs/{mockResponse}', [MockResponseController::class, 'docsShow'])->name('docs.show');
