<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\ExportResource;

class ExportResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $arr = [
            'name' => $this->name,
            'type' => $this->type,
            'blob' => $this->blob,
        ];

        if ($this->comment) {
            $arr['comment'] = $this->comment;
        }

        if ($this->image && $this->image->name) {
            $arr['image'] = [
                'name' => $this->image->name,
                'blob' => $this->image->blob
            ];
        }

        if ($this->categories()->exists()) {
            $arr['categories'] = (function ($categories) {
                $categories_arr = [];

                foreach ($categories as $category) {
                    $category_arr = [
                        'name' => $category->name
                    ];
                    
                    array_push($categories_arr, $category_arr);
                }

                return $categories_arr;
            })($this->categories);
        }

        if ($this->playlists()->exists()) {
            $arr['playlists'] = (function ($playlists) {
                $playlists_arr = [];

                foreach ($playlists as $playlist) {
                    $playlist_arr = [
                        'name' => $playlist->name,
                        'position' => $playlist->pivot->position
                    ];

                    array_push($playlists_arr, $playlist_arr);
                }

                return $playlists_arr;
            })($this->playlists);
        }

        return $arr;
    }
}
