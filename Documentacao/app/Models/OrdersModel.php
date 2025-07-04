<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdersModel extends Model
{
    protected $fillable = ['product', 'type', 'price', 'quantity', 'user_id'];
    protected $table = 'orders';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function product(): Attribute
    {
        return Attribute::make(
            get: fn(string $product) => ucfirst($product),
        );
    }

    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn(string $type) => ucfirst($type),
        );
    }


    protected function casts(): array
    {
        return [
            'selling' => 'boolean'
        ];
    }
}
