<?php

namespace App\Http\Controllers;

use App\Brandable;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($number  = null)
    {
        // Verify is there is an existing cached index of Products
        if (cache('product_index')) {
            $products = cache('product_index');
        } else {
            $products = Product::all();
            cache(['product_index' => $products], now()->addMinutes(5));
        }

        if ($number) {
            return $products->take($number);
        }

        return $products;
    }

    public function noCachedIndex($number  = null)
    {
        return $products = Product::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vars = $request->all();

        $product = ($request->id) ? Product::find($request->id) : new Product;

        foreach ($vars as $key => $value) {
            $product[$key] = $value;
        }

        if ($request->image) {
            if ($request->file('image')->isValid()) {
                $path = $request->file('image')->store('public');
                $product->image = $path;
            }
        }

        $product->save();

        $products = Brandable::where([
            ['brand_id', '=', $product->brand_id],
            ['brandable_id', '=', $product->type_id],
        ]);

        if ($products->count() === 0) {
            $product->type->brands()->save($product->brand);
        }

        Cache::flush();

        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->id;

        return Product::find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Product::find($request->id);

        $type = $product->type;

        $product->delete();

        $products = Product::where([
            ['brand_id', '=', $product->brand_id],
            ['type_id', '=', $product->type_id],
        ]);

        if ($products->count() === 0) {
            $type->brands()->delete($product->brand);
        }

        Cache::flush();

        return $product;
    }
    /**
     *  Shows a product 
     * 
     * @param \App\Product $product
     * @return view(Admin.List)
     */
    public function list(Product $product)
    {
        $type = $product->type;
        $brand = $product->brand;
        $product->type_name = $type->name;
        $product->brand_name = $brand->name;

        $brands = $type->brands()->getResults();

        return view('admin.list')->with(['brands' => $brands, 'product' => $product, 'type' => $type]);
    }
}
