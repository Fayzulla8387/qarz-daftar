<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/call',[\App\Http\Controllers\QarzConteroller::class,'call'])->name('call');
