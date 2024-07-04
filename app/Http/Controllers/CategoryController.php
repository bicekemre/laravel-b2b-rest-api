<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function list($slug, Request $request)
    {
        $categories = Categories::all();

        $category = Categories::query()
            ->where('slug',$slug)
            ->with(['products' => function ($query) {
                $query->with('imageable')->with('organizations');
            }])
        ->paginate(
            perPage: $request->limit,
            page: $request->offset
        );


        return response()->json([
            'categories' => $categories,
            'category' => $category,
        ]);
    }
}
