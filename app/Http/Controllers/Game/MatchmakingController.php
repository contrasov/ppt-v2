<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\GameMatched;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class MatchmakingController extends Controller
{
    public function show(Request $request)
    {
        return Inertia::render('game/Matchmaking');
    }

    public function searchMatch(Request $request)
    {
        $user = $request->user();
    
        // 1. Verifica se o jogador já foi pareado
        $matchedGames = Cache::get('matched_games', []);
        foreach ($matchedGames as $token => $players) {
            if (in_array($user->id, $players)) {
                return Inertia::render('game/Matchmaking', [
                    'status' => 'matched',
                    'message' => 'Partida já encontrada!',
                    'token' => $token,
                    'players' => $players,
                ]);
            }
        }
    
        $queue = Cache::get('matchmaking_queue', []);
        if (!in_array($user->id, $queue)) {
            $queue[] = $user->id;
            Cache::put('matchmaking_queue', $queue, now()->addMinutes(5));
        }
    
        if (count($queue) < 2) {
            return Inertia::render('game/Matchmaking', [
                'status' => 'searching',
                'message' => 'Aguardando outro jogador...',
                'position' => array_search($user->id, $queue) + 1
            ]);
        }
    
        $player1 = array_shift($queue);
        $player2 = array_shift($queue);
        Cache::put('matchmaking_queue', $queue, now()->addMinutes(5));
    
        $token = bin2hex(random_bytes(16));
        event(new GameMatched($player1, $player2, $token));
    
        // 5. Salva a partida
        $matchedGames[$token] = [$player1, $player2];
        Cache::put('matched_games', $matchedGames, now()->addMinutes(10));
    
        return Inertia::render('game/Matchmaking', [
            'status' => 'matched',
            'message' => 'Partida encontrada!',
            'token' => $token,
            'players' => [$player1, $player2],
        ]);
    }
    
}
