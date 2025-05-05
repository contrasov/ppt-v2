<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'is_initial',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cards()
    {
        return $this->belongsToMany(Card::class, 'deck_card')->withPivot('quantity');
    }


}
