<?php

use App\Events\ReactedEvent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::post('/reaction', function () {
    ReactedEvent::dispatch(request()->input('buttonId'), request()->input('reaction'));
});
