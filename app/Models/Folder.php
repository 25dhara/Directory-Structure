<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Folder extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id'
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user__folders', 'folder_id', 'permission_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user__folders', 'folder_id', 'user_id')
            ->withPivot('permission_id')
            ->withTimestamps();
    }
    public function files()
    {
        return $this->hasMany(File::class);
    }
}
