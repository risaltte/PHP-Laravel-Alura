<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSeries;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        // busca todas as séries
        // $series = Serie::all();

        // busca todas as séries de forma ordenada
        $series = Serie::query()
            ->orderBy('nome')
            ->get();

        // pegar mensagem da sessão
        $mensagem = $request->session()->get('mensagem');
        //$request->session()->remove('mensagem');

        /* A função compact a partir de uma string busca uma variável com o mesmo nome
        da string e cria um array associativo, sendo a string a chave e a variável o valor
        algo como ['string' = $string] */
        return view('series.index', compact('series', 'mensagem'));
    }

    public function create()
    {
        // retorna arquivo create da pasta views/series
        return view('series.create');
    }

    public function store(SeriesFormRequest $request, CriadorDeSerie $criadorDeSerie)
    {
//        $nome = $request->nome;
//        $serie = (Serie::create([
//            'nome' => $nome
//        ]));

        // forma mais sussinta para pegar tudo o que vier do request
        //$serie = Serie::create($request->all());

        $serie = $criadorDeSerie->criarSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada
        );


        // armazenar dados em sessão para flash message
        $request->session()
            ->flash(
                'mensagem',
                "Série {$serie->id} e suas temporadas e episódios criada com sucesso: {$serie->nome}"
        );

        // redirecionar usuário
        // return redirect('/series');

        // redirecionar usuário com rota nomeada
        return redirect()->route('listar_series');
    }

    public function destroy(Request $request , RemovedorDeSeries $removedorDeSeries)
    {

        $nomeSerie = $removedorDeSeries->removerSerie($request->id);

        // excluir série a partir do id obtido na request
       // Serie::destroy($request->id);

        // armazenar dados em sessão para flash message
        $request->session()
            ->flash(
                'mensagem',
                "Série $nomeSerie removida com sucesso"
        );

        // redirecionar usuário
        // return redirect('/series');

        // redirecionar usuário com rota nomeada
        return redirect()->route('listar_series');
    }

    public function editaNome(int $id, Request $request)
    {
        $novoNome = $request->nome;
        $serie = Serie::find($id);
        $serie->nome = $novoNome;
        $serie->save();
    }
}

