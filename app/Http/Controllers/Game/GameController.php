<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Deck;
use Illuminate\Support\Facades\Auth;
use App\Models\Card;
use Illuminate\Support\Facades\Cache;

class GameController extends Controller
{
    public function getGame(Request $request, $token)
    {
        $matchedGames = Cache::get('matched_games', []);

        if (!isset($matchedGames[$token])) {
            return redirect()->route('home')->with('error', 'Jogo não encontrado.');
        }

        [$p1, $p2] = $matchedGames[$token];

        if (Auth::id() === $p1['id']) {
            $player1 = $p1;
            $player2 = $p2;
        } elseif (Auth::id() === $p2['id']) {
            $player1 = $p2;
            $player2 = $p1;
        } else {
            return redirect()->route('home')->with('error', 'Você não tem permissão para acessar este jogo.');
        }

        $deck = Deck::where('user_id', Auth::user()->id)->get();
        $card_deck = Card::whereIn('id', function ($query) {
            $query->select('card_id')
                ->from('deck_card')
                ->where('deck_id', Deck::where('user_id', Auth::user()->id)->pluck('id'));
        })->get();

        return Inertia::render('game/Game', [
            'deck' => $deck,
            'card_deck' => $card_deck,
            'player1' => $player1['username'],
            'player2' => $player2['username']
        ]);
    }
}
