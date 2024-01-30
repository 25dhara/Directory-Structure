<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'folder_id',
        'path',
        'name',
        'display_name',
        'extension',
        'user_id'
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
