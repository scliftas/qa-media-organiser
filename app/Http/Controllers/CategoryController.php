<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Auth;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryRepository $category) {
        $this->category = $category;
    }

    public function get(Request $request) {
        return CategoryResource::collection($this->category->all()->where('user_id', Auth::user()->id))->resolve(); 
    }
}
