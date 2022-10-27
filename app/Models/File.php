<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'public_id', 'type', 'uploaded_by_id'
    ];
    protected $appends = ['file_url'];

    public function getFileUrlAttribute()
    {
        if (strpos($this->type, 'image') !== false) {
            return getFromCloudinary($this->public_id);
        } else {
            return getFromCloudinary($this->public_id, ['resource_type' => 'raw']);
        }
    }
}
