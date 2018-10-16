<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Auth;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\DeleteCategoryRequest;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryRepository $category) {
        $this->category = $category;
    }

    public function get(Request $request) {
        return CategoryResource::collection($this->category->all()->where('user_id', Auth::user()->id))->resolve(); 
    }

    public function create(CreateCategoryRequest $request) {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $category = new CategoryResource($this->category->create($data));
        return $category->resolve();
    }

    public function delete(DeleteCategoryRequest $request) {
        return $this->category->delete($request->input('id'));
    }
}
