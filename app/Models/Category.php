<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'name'
    ];

    public function files()
    {
        return $this->belongsToMany('App\Models\File', 'category_files', 'category_id', 'file_id');
    }
}
