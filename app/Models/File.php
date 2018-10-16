<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'comment',
        'path'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function image()
    {
        return $this->hasOne('App\Models\Image');
    }

    public function playlists()
    {
        return $this->belongsToMany('App\Models\Playlist', 'playlist_files', 'file_id', 'playlist_id')->withPivot('position');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_files', 'file_id', 'category_id');
    }
}
