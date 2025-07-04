<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index() //Otimizado
    {
        return response()->json(Auth::user());
    }

    public function update(Request $request)
    {
        $userId = Auth::id();
        $credentials = $request->only(['name', 'email', 'password', 'money']);

        if (!User::query()->where('id', $userId)->update($credentials)) {
            response()->json('Falha ao atualizar o seu perfil');
        };

        return response()->json('Sucesso ao atualizar o seu perfil');
    }

    public function destroy(Request $request)
    {
        if (!User::destroy($request->id)) {
            return response()->json('Falha ao apagar a perfil');
        }
        return response()->json('Sucesso ao apagar perfil');
    }
}
