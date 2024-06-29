<?php

namespace App\Http\Controllers;

use App\Models\Organizations;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class OrganizationController extends Controller
{
    public function items($offset = 1, $limit = 10)
    {
        $organizations = Organizations::query()->orderBy('id', 'desc')->paginate(
            perPage: $limit,
            page: $offset
        );

        return response()->json([$organizations]);
    }

    public function item($id)
    {
        $organization = Organizations::with('products')->findOrFail($id);

        return response()->json($organization);
    }

    public function create(Request $request)
    {
        $organization = new Organizations();

        $organization->name = $request->name;
        $organization->slug = Str::slug($request->name);
        $organization->phone = $request->phone;
        $organization->address = $request->address;
        $organization->city = $request->city;
        $organization->zip = $request->zip;

        $organization->save();

        return response()->json($organization);
    }

    public function update($id, Request $request)
    {
        $organization = Organizations::query()->findOrFail($id);

        $organization->name = $request->name;
        $organization->phone = $request->phone;
        $organization->address = $request->address;
        $organization->city = $request->city;
        $organization->zip = $request->zip;

        $organization->save();
    }

    public function addStock(Request $request)
    {
        $organization = Organizations::query()->findOrFail($request->organization_id);
        $product = Product::query()->where('code', $request->product_code)->firstOrFail();

        $organization->products()->attach($product->id, ['stock' => $request->stock]);

        return response()->json([], Response::HTTP_OK);
    }

    public function delete($id)
    {
        $organization = Organizations::query()->findOrFail($id);
        $organization->delete();

        return response()->json('deleted successfully');
    }


}
