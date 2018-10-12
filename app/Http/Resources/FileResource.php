<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

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
            'image' => $this->image(),
            'playlists' => $this->playlists(),
            'categories' => $this->categories()
        ];
    }
}
