<?php

namespace App\Http\Controllers;

use App\Type;

class NavController extends Controller
{
    static public function index()
    {
        $routes = [];

        $routes[0]['link'] = 'carousel';
        $routes[0]['name'] = "carrossel";

        $routes[2]['link'] = 'product';
        $routes[2]['name'] = 'produto';

        $routes[3]['link'] = 'type';
        $routes[3]['name'] = 'tipo';

        $routes[4]['link'] = 'brand';
        $routes[4]['name'] = 'marca';

        return $routes;
    }

    public function itens()
    {

        $response = [];

        $types = Type::all();
        foreach ($types as $item) {
            $brands[$item->id] = $item->brands()->getResults();
        }

        $response['types'] = $types;
        $response['brands'] = $brands;

        return $response;
    }
}
