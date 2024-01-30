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
        'created_by'
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
