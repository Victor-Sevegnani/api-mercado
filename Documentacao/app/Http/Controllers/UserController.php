<?php

namespace App\Http\Controllers;

use App\Models\OrdersModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('orders')->get();
        return response()->json($users);
    }

    public function update(Request $request)
    {
        $userId = Auth::id();
        $credentials = $request->all();

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
