<?php

namespace Tests\Feature;

use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSeries;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RemovedorDeSerieTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Serie
     */
    private $serie;

    protected function setUp(): void
    {
        parent::setUp();
        $criadorDeSerie = new CriadorDeSerie();
        $this->serie = $criadorDeSerie->criarSerie(
            'Nome da série',
            1,
            1
        );

    }

    public function testRemoverUmaSerie()
    {
        $this->assertDatabaseHas('series', ['id' => $this->serie->id]);
        $removodorDeSerie = new RemovedorDeSeries();
        $nomeSerie = $removodorDeSerie->removerSerie($this->serie->id);
        $this->assertIsString($nomeSerie);
        $this->assertEquals('Nome da série', $nomeSerie);
        $this->assertDatabaseMissing('series', ['id' => $this->serie->id] );
    }
}
