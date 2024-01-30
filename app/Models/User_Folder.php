<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Folder extends Model
{
    use HasFactory;
    protected $table = 'user__folders';
    protected $fillable = [
        'folder_id',
        'user_id',
        'permission_id',
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
