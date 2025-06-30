<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(\Illuminate\Support\Facades\Response $response)
    {
        return $response::json('Bem vindo ao sistema');
    }

    public function store(Request $request, \Illuminate\Support\Facades\Response $response)
    {
        $credentials = $request->all();
        if (!User::create($credentials)) {
            return $response::json('Erro ao criar usuário', 400);
        };
        return $response::json('Usuário criado com sucesso', 201);
    }

    public function login(Request $request, \Illuminate\Support\Facades\Response $response)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return $response::json('Dados inválidos');
        };

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;
        return $response::json('Logado com sucesso, seu token: ' . $token);
    }
}
