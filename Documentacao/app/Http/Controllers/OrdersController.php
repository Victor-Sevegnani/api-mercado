<?php

namespace App\Http\Controllers;

use App\Models\OrdersModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = OrdersModel::all();
        return $orders->count() != 0
            ? \response()->json($orders)
            : \response()->json('Nenhum produto encontrado');
    }

    public function store(Request $request): JsonResponse
    {
        $items = $request->only(['product', 'type', 'price', 'quantity']);

        if (OrdersModel::query()->where('product', $items['product'])->exists()) {
            return \response()->json(['message' => 'Itens já registrados'], 400);
        }

        return \response()->json(['message' => 'Itens criados com sucesso'], 201);
    }

    public function update(Request $request): JsonResponse
    {
        $items = $request->only(['product', 'type', 'price', 'quantity']);
        $query = OrdersModel::query();

        if (!$query->update($items)) {
            return \response()->json('Falha ao atualizar o produto');
        };

        return \response()->json('Sucesso ao atualizar o produto');
    }

    public function destroy($id): JsonResponse
    {
        if (!OrdersModel::destroy($id)) {
            return \response()->json('Falha ao apagar o produto');
        };
        return \response()->json('Sucesso ao apagar o produto');
    }

    public function find(int $id): JsonResponse
    {
        return \response()->json(OrdersModel::find($id));
    }

}
