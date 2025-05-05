<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'effect',
        'rarity',
        'cost',
        'link_img',
        'percentage_drop'
    ];

    public function decks()
    {
        return $this->belongsToMany(Deck::class);
    }
}
