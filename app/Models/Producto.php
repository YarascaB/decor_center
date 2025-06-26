<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    // Campos asignables masivamente
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'description',
    ];

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class, 'product_id');
    }

}
