<?php

namespace App\Http\Controllers\Card;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use Inertia\Inertia;

class DeckController extends Controller
{
    public function show(Request $request)
    {
        $cards = Card::all(); //busca todas as cartas do banco
        return Inertia::render('deck/Cards', [
            'cards' => $cards
        ]);
    }
}
