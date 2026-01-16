<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


Route::get('/run-livewire-config', function () {
    Artisan::call('livewire:publish --config');
    return 'Livewire config published!';
});

Route::get('/run-storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created successfully.';
});