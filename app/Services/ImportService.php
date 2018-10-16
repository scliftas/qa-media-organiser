<?php

namespace App\Services;

use App\Models\File;
use App\Models\Image;
use App\Models\Category;
use App\Models\Playlist;
use App\Repositories\FileRepository;
use App\Repositories\ImageRepository;
use Storage;

class ImportService {
    protected $file_repository;
    protected $image_repository;

    public function __construct(File $file, Image $image) {
        $this->file_repository = new FileRepository($file);
        $this->image_repository = new ImageRepository($image);
    }

    public function run($data, $user_id) {
        $import = json_decode(file_get_contents($data['file']));

        foreach ($import as $file) {
            $saved_file = $this->file_repository->createFromBlob($file);
            
            if (property_exists($file, 'image')) {
                $file->image->file_id = $saved_file->id;
                $image = $this->image_repository->createFromBlob($file->image);
            }

            if (property_exists($file, 'categories')) {
                foreach ($file->categories as $category) {
                    $saved_category = Category::updateOrCreate([
                        'name' => $category->name,
                        'user_id' => $user_id
                    ]);
                    
                    $saved_file->categories()->attach($saved_category->id);
                }
            }

            if (property_exists($file, 'playlists')) {
                foreach ($file->playlists as $playlist) {
                    $saved_playlist = Playlist::updateOrCreate([
                        'name' => $playlist->name,
                        'user_id' => $user_id,
                    ]);
                    
                    $saved_file->playlists()->attach($saved_playlist->id, [
                        'position' => $playlist->position
                    ]);
                }
            }
        }

        return [
            'files' => $this->file_repository->all()->where('user_id', $user_id),
            'playlists' => Playlist::where('user_id', $user_id)->get(),
            'categories' => Category::where('user_id', $user_id)->get()
        ];
    }
}