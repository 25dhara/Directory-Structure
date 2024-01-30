<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    use HasRoles;


    protected $fillable = [
        'name'
    ];
    protected $guard = null;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
