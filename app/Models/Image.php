<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'file_id',
        'name',
        'path'
    ];

    public function file()
    {
        return $this->belongsTo('App\Models\File');
    }
}
