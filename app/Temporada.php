<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    protected $fillable = ['numero'];
    public $timestamps = false;    // não cria os campos de timestamps na tabela (update_a, created_at)

    // relacionamento com o Episodio (OneToMany) - uma temporada tem vários episódios
    // nome do método no plural
    public function episodios()
    {
        return $this->hasMany(Episodio::class);
    }

    // relacionamento com Serie (OneToOne) - Uma temporada pertence a uma série
    // nome do método no singular
    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }

    public function getEpisodiosAssitidos(): Collection
    {
        return $this->episodios->filter(function (Episodio $episodio) {
            return $episodio->assistido;
        });
    }
}
