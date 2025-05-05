<?php

namespace App\Http\Controllers\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use Inertia\Inertia;
use App\Models\Deck;
use Illuminate\Support\Facades\Auth;

class DeckController extends Controller
{
    public function show(Request $request)
    {
        $cards = Card::all(); //busca todas as cartas do banco
        return Inertia::render('deck/Cards', [
            'cards' => $cards
        ]);
    }

    public function showDecks(Request $request)
    {
        $decks = Deck::where('user_id', Auth::user()->id)->get();

        $card_deck = Card::whereIn('id', function ($query) {
            $query->select('card_id')
                ->from('deck_card')
                ->where('deck_id', Deck::where('user_id', Auth::user()->id)->pluck('id'));
        })->get();

        return Inertia::render('deck/Decks', [
            'decks' => $decks,
            'card_deck' => $card_deck
        ]);
    }

    public function createInitialDeck()
    {
        $existingDeck = Deck::where('user_id', Auth::user()->id)->where('is_initial', true)->first();

        if ($existingDeck) {
            return response()->json(['message' => 'Você já tem um deck inicial'], 400);
        }

        $deck = new Deck();
        $deck->user_id = Auth::user()->id;
        $deck->name = 'Deck inicial';
        $deck->description = 'Seu primeiro deck, com 20 cartas comuns';
        $deck->is_initial = true;
        $deck->save();

        $deck_cards = [];

        $cards = Card::where('rarity', 'Comum')->limit(20)->get();
        foreach ($cards as $card) {
            $deck_cards[] = [
                'deck_id' => $deck->id,
                'card_id' => $card->id,
                'quantity' => 1
            ];
        }

        $deck->cards()->attach($deck_cards);

        return response()->json(['message' => 'Deck inicial criado com sucesso'], 201);
    }
}
