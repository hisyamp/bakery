<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cutoff extends Model
{
    use HasFactory;
    protected $table = 'cutoff';
    protected $guard = [];
    protected $timestamp = true;
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'id',
        'cutoff_name',
        'start_date',
        'end_date',
        'status',
        'type_log_id',
        'notes',
        'created_at',
        'closed_by',
        'closed_at',
        'is_active',
    ];
    
}
