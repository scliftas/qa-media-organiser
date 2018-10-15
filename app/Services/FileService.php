<?php

namespace App\Services;

use App\Models\File;
use App\Models\Image;
use App\Repositories\FileRepository;
use App\Repositories\ImageRepository;

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
            $image = $this->image_repository->updateOrCreate($data['image']);
        }

        return $file;
    }

    public function delete($id) {
        $file = $this->file_repository->getWith($id);
        $file->categories()->detach();
        $file->playlists()->detach();
        $file->image()->delete();
        return $this->file_repository->delete($id);
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
        foreach ($data['playlists'] as $playlist) {
            $file->playlists()->attach($playlist['id'], [
                'position' => $playlist['position']
            ]);
        }
    }

    private function attachFileToCategories($data, $file) {
        foreach ($data['categories'] as $category) {
            $file->categories()->attach($category['id']);
        }
    }
}