<?php

namespace App\Services;

use App\{Episodio, Serie, Temporada};
use Illuminate\Support\Facades\DB;

class RemovedorDeSeries
{
    public function removerSerie(int $serieId): string
    {
        $nomeSerie = '';
        DB::transaction(function () use($serieId, &$nomeSerie) {
            // buscar a série
            $serie = Serie::find($serieId);

            $nomeSerie = $serie->nome;

            $this->removerTemporadas($serie);
            $serie->delete();
        });

        return $nomeSerie;
    }

    private function removerTemporadas(Serie $serie): void
    {
        $serie->temporadas->each(function (Temporada $temporada) {
            $this->removerEpisodios($temporada);
            $temporada->delete();
        });
    }

    private function removerEpisodios(Temporada $temporada): void
    {
        $temporada->episodios->each(function (Episodio $episodio) {
            $episodio->delete();
        });
    }
}
