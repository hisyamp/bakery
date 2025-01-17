<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $guard = [];
    protected $timestamp = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];
    
}
