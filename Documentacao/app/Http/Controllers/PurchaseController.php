<?php

namespace App\Http\Controllers;

use App\Models\OrdersModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function purchase(Request $request)
    {
        $product = $request->input('product');
        $query = OrdersModel::query()->where('product', $product)->first();
        $userMoney = User::query()->first('money')->money;
        $quantity = OrdersModel::query()->first('quantity')->quantity;

        if (!($userMoney > $query->price)) {
            return response()->json('Falha ao comprar! dinheiro insuficiente');
        }
        User::query()->update(
            [
                'money' => $userMoney - $query->price,
                'orders' => $product,
            ]);

        OrdersModel::query()->update(
            [
                'quantity' => $quantity - 1
            ]);
        return response()->json("Sucesso, {$query->product} comprado com sucesso");
    }
}
