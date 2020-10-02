<?php

namespace App\Services;

use App\Serie;
use App\Temporada;
use Illuminate\Support\Facades\DB;

class CriadorDeSerie
{
    public function criarSerie(string $nomeSerie, int $qtdTemporadas, int $epPorTemporada): Serie
    {
        // iniciar uma transação
        DB::beginTransaction();

        $serie = Serie::create(['nome' => $nomeSerie]);
        $this->criaTemporadas($qtdTemporadas, $epPorTemporada, $serie);

        // Commit - OBS.: caso houver qualquer erro o commit não será executado
        DB::commit();

        return $serie;
    }

    private function criaTemporadas(int $qtdTemporadas, int $epPorTemporada, Serie $serie): void
    {
        for ($i = 1; $i <= $qtdTemporadas; $i++) {
            /** @var Temporada $temporada */
            $temporada = $serie->temporadas()->create(['numero' => $i]);
            $this->criaEpisodios($temporada, $epPorTemporada);
        }
    }

    private function criaEpisodios(Temporada $temporada, int $epPorTemporada): void
    {
        for ($j = 1; $j <= $epPorTemporada; $j++) {
            $temporada->episodios()->create(['numero' => $j]);
        }
    }

}
