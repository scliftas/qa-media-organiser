<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\PlaylistRepository;
use Illuminate\Http\Request;
use App\Http\Resources\PlaylistResource;
use Auth;
use App\Http\Requests\CreatePlaylistRequest;
use App\Http\Requests\DeletePlaylistRequest;
use App\Http\Requests\UpdatePlaylistRequest;

class PlaylistController extends Controller
{
    protected $playlist;

    public function __construct(PlaylistRepository $playlist) {
        $this->playlist = $playlist;
    }

    public function get(Request $request) {
        return PlaylistResource::collection($this->playlist->all()->where('user_id', Auth::user()->id))->resolve(); 
    }

    public function create(CreatePlaylistRequest $request) {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $category = new PlaylistResource($this->playlist->create($data));
        return $category->resolve();
    }

    public function delete(DeletePlaylistRequest $request) {
        return $this->playlist->delete($request->input('id'));
    }

    public function update(UpdatePlaylistRequest $request) {
        $data = $request->all();
        unset($data['id']);
        return $this->playlist->update($data, $request->input('id'));
    }
}
