<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Game\GameController;
use App\Http\Controllers\Game\MatchmakingController;

Route::get('game/{token}', [GameController::class, 'getGame'])
    ->middleware('auth')
    ->name('game.play');

Route::middleware('auth')->group(function () {
    Route::post('matchmaking/search', [MatchmakingController::class, 'searchMatch'])
        ->name('matchmaking.search');

    Route::get('matchmaking', [MatchmakingController::class, 'show'])
        ->name('matchmaking');

    Route::post('matchmaking/give-up', [MatchmakingController::class, 'giveUp'])
        ->name('matchmaking.give-up');
});
