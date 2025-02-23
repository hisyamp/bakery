<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logitem extends Model
{
    use HasFactory;
    protected $table = 'log_items';
    protected $guard = [];
    protected $timestamp = true;
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'id',
        'item_id',
        'branch_id',
        'type_log_id',
        'notes',
        'status',
        'qty',
        'price',
        'list_item',
        'created_at',
        'created_by',
        'updated_at',
        'deleted_at',
    ];
    
}
