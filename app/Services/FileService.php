<?php

namespace App\Services;

use App\Models\File;
use App\Models\Image;
use App\Models\Playlist;
use App\Repositories\FileRepository;
use App\Repositories\ImageRepository;
use DB;

class FileService {
    protected $file_repository;
    protected $image_repository;

    public function __construct(File $file, Image $image) {
        $this->file_repository = new FileRepository($file);
        $this->image_repository = new ImageRepository($image);
    }

    public function all() {
        return $this->file_repository->all();
    }

    public function create($data) {
        return $this->file_repository->create($data);
    }

    public function get($id) {
        return $this->file_repository->get($id);
    }

    public function update($data) {
        $file = $this->updateFile($data);

        if (array_key_exists('image', $data)) {
            $image = $this->image_repository->updateOrCreate($data['image'], $file->id);
        }

        return $file;
    }

    public function delete($id) {
        $file = $this->file_repository->get($id);
        $file->categories()->detach();
        $file->playlists()->detach();
        $file->image()->delete();
        return $this->file_repository->delete($id);
    }

    public function moveFileDown($data) {
        $lower_file = DB::table('playlist_files')->where('playlist_id', $data['playlist_id'])->where('position', $data['position'] + 1);
        
        $file = DB::table('playlist_files')->where('playlist_id', $data['playlist_id'])->where('file_id', $data['file_id'])->where('position', $data['position']);

        $lower_file->update(array('position' => $data['position']));
        $file->update(['position' => $data['position'] + 1]);
        
        return $this->all();
    }

    private function updateFile($data) {
        $file = $this->file_repository->update($data['file'], $data['file']['id']);

        if (array_key_exists('playlists', $data)) {
            $this->attachFileToPlaylists($data, $file);
        }

        if (array_key_exists('categories', $data)) {
            $this->attachFileToCategories($data, $file);
        }

        return $file;
    }

    private function attachFileToPlaylists($data, $file) {
        $file->playlists()->detach();
        $data['playlists'] = array_unique($data['playlists']);

        foreach ($data['playlists'] as $playlist) {
            $last_position = DB::table('playlist_files')->where('playlist_id', $playlist)->max('position');
            $file->playlists()->attach($playlist, [
                'position' => $last_position !== null ? $last_position++ : 1
            ]);
        }
    }

    private function attachFileToCategories($data, $file) {
        $file->categories()->detach();
        $data['categories'] = array_unique($data['categories']);
        foreach ($data['categories'] as $category) {
            $file->categories()->attach($category);
        }
    }
}