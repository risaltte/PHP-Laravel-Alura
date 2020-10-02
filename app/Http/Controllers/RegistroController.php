<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function create()
    {
        return view('registro.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');             // pega todos os dados da requisição exceto _token
        $data['password'] = Hash::make($data['password']);     // faz um hash da senha
        $user = User::create($data);                           // cria o usuário com os dados e retorna um usuário

        Auth::login($user);                                 // faz login do usuário

        return redirect()->route('listar_series');  // depois de logar redireciona o usuário
    }
}
