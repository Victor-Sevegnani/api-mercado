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

    public function store(Request $request, \Illuminate\Support\Facades\Response $response) // Melhorado
    {
        $credentials = $request->only(['name', 'email', 'password', 'money']);
        if (!User::query()->where('email', $credentials['email'])->exists()) {
            User::query()->create($credentials);
            return $response::json('Usuário criado com sucesso', 201);
        }
        return $response::json('Usuário já existente', 400);
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
