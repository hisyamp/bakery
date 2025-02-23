<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    // Define the table name if it's not the pluralized version of the model
    protected $table = 'categories';

    // Allow mass assignment for the 'name' column
    protected $fillable = ['name'];

    // Define dates for soft deletes
    protected $dates = ['deleted_at'];
}
