<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = [
        'name'
    ];

    public function files()
    {
        return $this->belongsToMany('App\Modles\File', 'playlist_files', 'playlist_id', 'file_id');
    }
}
