<?php

namespace App\Http\Controllers;

use App\Models\OrganizationHasProducts;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    public function items($offset = 1, $limit = 10)
    {
        $products = Product::query()->orderBy('id', 'desc')
            ->offset($offset*$limit)
            ->limit($limit)
            ->get();

        return response()->json($products,Response::HTTP_OK);
    }

    public function item($id)
    {
        $product = Product::query()->findOrFail($id);

        return response()->json($product);
    }

    public function create(Request $request)
    {

        $product = new Product();

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->code = $request->code;
        $product->price = $request->price;
        $product->status = $request->status;

        $product->save();

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::query()->findOrFail($id);

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->code = $request->code;
        $product->price = $request->price;
        $product->status = $request->status;

        $product->save();

        return response()->json($product);
    }

    public function activate($id)
    {
        $product = Product::query()->findOrFail($id);
        $product->status = 1;
        $product->save();
        return response()->json($product);
    }

    public function stock()
    {
        $products = Product::query()
            ->whereHas('stock')
            ->with('imageable')
            ->get();


        return response()->json($products);
    }

    public function delete($id)
    {
        $product = Product::query()->findOrFail($id);

        $product->delete();
        return response()->json('deleted successfully');
    }
}
