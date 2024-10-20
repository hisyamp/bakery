<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logtype extends Model
{
    use HasFactory;
    protected $table = 'log_types';
    protected $guard = [];
    protected $timestamp = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
    ];
    
}
