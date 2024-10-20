<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $guard = [];
    protected $timestamp = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'category',
        'is_active',
        'branch_id',
        'created_at',
        'created_by',
        'updated_at',
        'deleted_at',
    ];
    
}
