<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episodio extends Model
{
    protected $fillable = ['numero'];
    public $timestamps = false;    // não cria os campos de timestamps na tabela (update_a, created_at)

    // relacionamento com Temporada (OneToOne) - Um Episodio pertence a uma Temporada
    // nome do método no singular
    public function temporada()
    {
        return $this->belongsTo(Temporada::class);
    }
}
