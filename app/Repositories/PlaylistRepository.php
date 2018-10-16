<?php

namespace App\Repositories;

use App\Repositories\AbstractRepository;
use App\Models\Playlist;

class PlaylistRepository extends AbstractRepository {
    public function __construct(Playlist $category) {
        parent::__construct($category);
    }   

    public function delete($id) {
        $playlist = $this->get($id);
        $playlist->files()->detach();

        return parent::delete($id);
    }
}