<?php

namespace App\Http\Controllers;

use App\Type;
use Auth;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    /**
     * Display the main page.
     *
     * @return \Illuminate\Http\Response
     */
    public function main()
    {
        $types = [];
        $brands = [];

        $types = Type::all();
        foreach ($types as $type) {
            $brands[$type->id] = $type->brands()->getResults();
        }

        cache(['types' => $types], now()->addMinutes(5));
        cache(['marcas' => $brands], now()->addMinutes(5));

        if (Auth::user() && Auth::user()->email_verified_at) {
            $links = NavController::index();
            cache(['links' => $links], now()->addMinutes(5));
        }

        return view('welcome');
    }
}
