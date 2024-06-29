<?php

namespace App\Http\Controllers;

use App\Models\OrganizationHasProducts;
use App\Models\Organizations;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfferController extends Controller
{
    public function list()
    {
        $offset = 0; $limit = 10;
        $offers = OrganizationHasProducts::query()
            ->with('product')
            ->orderBy('organization_id', 'desc')
            ->offset($offset*$limit)
            ->limit($limit)
            ->get();

            return response()->json($offers ,Response::HTTP_OK);
    }
}
