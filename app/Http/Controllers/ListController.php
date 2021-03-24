<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use App\Type;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function typeBrand(Type $type, Brand $brand)
    {

        $products = Product::where([
            ['brand_id', '=', $brand->id],
            ['type_id', '=', $type->id],
        ])->get();

        $brands = $type->brands()->getResults();

        return view('admin.list')->with(['brands' => $brands, 'products' => $products, 'brand' => $brand, 'type' => $type]);
    }

    public function type(Type $type)
    {

        $brands = $type->brands()->getResults();

        $products = $type->products()->getResults();

        return view('admin.list')->with(['brands' => $brands, 'products' => $products, 'type' => $type]);
    }
}
