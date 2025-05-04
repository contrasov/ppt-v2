<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Card\DeckController;

Route::get('cards', [DeckController::class, 'show'])
    ->name('cards.all');
