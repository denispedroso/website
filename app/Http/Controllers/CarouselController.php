<?php

namespace App\Http\Controllers;

use App\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($number  = null)
    {
        // Verify is there is an existing cached index of Carousels
        if (cache('carousel_index')) {
            $carousels = cache('carousel_index');
        } else {
            $carousels = Carousel::all();
            cache(['carousel_index' => $carousels], now()->addMinutes(5));
        }

        if ($number) {
            return $carousels->take($number);
        }

        return $carousels;
    }

    public function noCachedIndex($number  = null)
    {
        return Carousel::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.carousel');
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

        $carousel = ($request->id) ? Carousel::find($request->id) : new Carousel;

        foreach ($vars as $key => $value) {
            $carousel[$key] = $value;
        }

        if ($request->item_image) {
            if ($request->file('item_image')->isValid()) {
                $path = $request->item_image->store('public');
                $carousel->item_image = $path;
            }
        }

        $carousel->save();
        Cache::flush();

        return $carousel;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return Carousel::find($request->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $carousel = Carousel::find($request->id);

        $carousel->delete();
        Cache::flush();

        return $carousel;
    }
}
