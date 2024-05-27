<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Role Model.
 */
class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'description'];
    protected $hidden = ['created_at', 'updated_at'];
}
