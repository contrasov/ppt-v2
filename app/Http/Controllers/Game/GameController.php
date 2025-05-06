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

        [$player1, $player2] = $matchedGames[$token];

        if (!in_array(Auth::id(), [$player1, $player2])) {
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
            'card_deck' => $card_deck
        ]);
    }
}
