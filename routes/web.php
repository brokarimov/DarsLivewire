<?php

use App\Http\Controllers\TestController;
use App\Livewire\CalcComponent;
use App\Livewire\HomeComponent;
use App\Livewire\StudentComponent;
use Illuminate\Support\Facades\Route;


Route::get('/', StudentComponent::class);

