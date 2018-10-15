<?php

namespace App\Repositories;

use App\Repositories\AbstractRepository;
use App\Models\Playlist;

class PlaylistRepository extends AbstractRepository {
    public function __construct(Playlist $category) {
        parent::__construct($category);
    }   
}