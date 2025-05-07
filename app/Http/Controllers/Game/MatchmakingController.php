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
        $queue = Cache::get('matchmaking_queue', []);
        $matchedGames = Cache::get('matched_games', []);



        foreach ($matchedGames as $token => $players) {
            if (in_array($user->id, array_column($players, 'id'))) {
                return Inertia::render('game/Matchmaking', [
                    'status' => 'matched',
                    'message' => 'Partida já encontrada.',
                    'token' =>$token,
                    'players' => $players,
                    'queue' => $queue,
                ]);
            }
        }
    
        $queue = Cache::get('matchmaking_queue', []);
        if (!in_array($user->id, array_column($queue, 'id'))) {
            $queue[] = [
                'id' => $user->id,
                'username' => $user->username,
            ];
            Cache::put('matchmaking_queue', $queue, now()->addMinutes(5));
        }
    
        if (count($queue) < 2) {
            return Inertia::render('game/Matchmaking', [
                'status' => 'searching',
                'message' => 'Aguardando outro jogador...',
                'position' => array_search($user->id, array_column($queue, 'id')) + 1
            ]);
        }
    
        $player1 = array_shift($queue);
        $player2 = array_shift($queue);
        Cache::put('matchmaking_queue', $queue, now()->addMinutes(5));
    
        $token = bin2hex(random_bytes(8));
        event(new GameMatched($player1, $player2, $token));
    
        $matchedGames[$token] = [$player1, $player2];
        Cache::put('matched_games', $matchedGames, now()->addMinutes(10));
    
        return Inertia::render('game/Matchmaking', [
            'status' => 'matched',
            'message' => 'Partida encontrada.',
            'token' => $token,
            'players' => [$player1, $player2],
            'queue' => $queue,
        ]);
    }

    public function giveUp(Request $request)
    {
        $user = $request->user();
        $token = $request->input('token');
    
        $matchedGames = Cache::get('matched_games', []);
    
        if (isset($matchedGames[$token])) {
            [$p1, $p2] = $matchedGames[$token];
    
            if ($user->id === $p1['id'] || $user->id === $p2['id']) {
                unset($matchedGames[$token]);
                Cache::put('matched_games', $matchedGames, now()->addSeconds(10));
            }
        }
    
        $queue = Cache::get('matchmaking_queue', []);
        $queue = array_values(array_filter($queue, function ($player) use ($user) {
            return $player['id'] !== $user->id;
        }));
        Cache::put('matchmaking_queue', $queue, now()->addSeconds(10));
    
        return Inertia::render('game/Matchmaking', [
            'message' => 'Você desistiu da partida.',
            'status' => 'give-up',
            'token' => $token,
        ]);
    }
    
    
}
