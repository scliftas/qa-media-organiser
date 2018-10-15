<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Storage;

class FileResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'path' => $this->path,
            'comment' => $this->comment,
            'image' => base64_encode(Storage::disk('local')->get($this->image->first()->name)),
            'playlists' => $this->playlists(),
            'categories' => $this->categories->pluck('id')->toArray()
        ];
    }
}
