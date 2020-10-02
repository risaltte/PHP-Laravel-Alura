<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// a tabela será acessada no banco com o nome da classe com letras em minúsculo e no plural (ex: series)

// Nosso modelo deve estender a classe Model que  tem a implementação dos métodos que o Laravel nos oferece

class Serie extends Model
{
    public $timestamps = false;         // não cria os campos de timestamps na tabela (update_a, created_at)

    protected $fillable = ['nome'];

    // relacionamento com a Temporada (OneToMany) - uma serie tem várias temporadas
    public function temporadas()
    {
        return $this->hasMany(Temporada::class);
    }
}
