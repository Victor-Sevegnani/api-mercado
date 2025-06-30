<?php

namespace App\Http\Controllers;

use App\Models\OrdersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class OrdersController extends Controller
{
    public function index(Response $response)
    {
        if (OrdersModel::all()->count() == 0) {
            return $response::json('Nenhum produto encontrado');
        }
        return $response::json(OrdersModel::all());
    }

    public function store(Request $request, Response $response)
    {
        $items = $request->only(['product', 'type', 'price', 'quantity']);
        $userId = Auth::id();

        $exists = OrdersModel::query()->where('product', $items['product'])
            ->exists();

        if (!$exists) {
            $items['user_id'] = $userId;
        } else {
            return $response::json('Itens já existentes');
        }

        if (!OrdersModel::create($items)) {
            return $response::json('Falha ao criar produto', 400);
        }

        return $response::json('Itens criados com sucesso', 201);
    }

    public function update(Request $request)
    {
        $items = $request->only(['product', 'type', 'price', 'quantity']);
        $query = OrdersModel::query();

        if (!$query->update($items)) {
            return \response()->json('Falha ao atualizar o produto');
        };

        return \response()->json('Sucesso ao atualizar o produto');
    }

    public function destroy($id)
    {
        if (!OrdersModel::destroy($id)) {
            return \response()->json('Falha ao apagar o produto');
        };
        return \response()->json('Sucesso ao apagar o produto');
    }

    public function find(int $id)
    {
        return \response()->json(OrdersModel::find($id));
    }

}
