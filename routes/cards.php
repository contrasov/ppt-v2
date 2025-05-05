<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Card\DeckController;

Route::get('cards', [DeckController::class, 'show'])
    ->name('cards.all');

Route::get('decks', [DeckController::class, 'showDecks'])
    ->name('decks.all');

Route::post('decks/initial', [DeckController::class, 'createInitialDeck'])
    ->middleware('auth')
->name('decks.initial');
