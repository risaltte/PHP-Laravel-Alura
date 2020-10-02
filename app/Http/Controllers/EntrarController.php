<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntrarController extends Controller
{
    public function index()
    {
        return view('entrar.index');
    }

    public function entrar(Request $request)
    {
        // o lavarel pegas os dados da requisição e tenta fazer o login
        // usando a classe Auth. O retorno é um boleano para a tentativa de login
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return redirect()
                ->back()
                ->withErrors('Usuário e/ou senha incorretos');
        }

        return redirect()->route('listar_series');
    }
}
