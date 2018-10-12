<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'path',
        'type',
        'comment',
        'blob'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function playlists()
    {
        return $this->belongsToMany('App\Models\Playlist', 'playlist_files', 'file_id', 'playlist_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_files', 'file_id', 'category_id');
    }
}
