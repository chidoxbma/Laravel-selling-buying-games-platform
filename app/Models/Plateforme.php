<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plateforme extends Model
{
    protected $table = 'plateforme';
    
    protected $fillable = [
        'nom',
        'description',
        'date_sortie',
        'genre',
        'image_url'
    ];

    public function jeux()
    {
        return $this->hasMany(Jeu::class);
    }
}
