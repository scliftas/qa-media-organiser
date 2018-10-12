<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name'
    ];

    public function files()
    {
        return $this->belongsToMany('App\Modles\File', 'category_files', 'category_id', 'file_id');
    }
}