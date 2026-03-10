<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jeu extends Model
{
    protected $table = 'jeux';
    
    protected $fillable = [
        'nom',
        'description',
        'date_sortie',
        'categorie',
        'image_url',
        'plateforme_id',
        'prix',
        'user_id',
        'sold',
        'sold_at',
        'buyer_id'
    ];

    public function plateforme()
    {
        return $this->belongsTo(Plateforme::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
