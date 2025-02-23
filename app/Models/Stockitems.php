<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stockitems extends Model
{
    use HasFactory;
    protected $table = 'stock_items';
    protected $guard = [];
    protected $timestamp = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'item_id',
        'stok_awal',
        'stok_akhir',
        'type_log_id',
        'transaction_date',
        'created_at',
        'created_by',
        'updated_at',
    ];
}
