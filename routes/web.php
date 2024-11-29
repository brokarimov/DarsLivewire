<?php

use App\Http\Controllers\TestController;
use App\Livewire\CalcComponent;
use App\Livewire\CategoryComponent;
use App\Livewire\HomeComponent;
use App\Livewire\PostComponent;
use App\Livewire\StudentComponent;
use Illuminate\Support\Facades\Route;


Route::get('/', CategoryComponent::class);
Route::get('/post', PostComponent::class);


