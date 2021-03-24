<?php

namespace App\Http\Middleware;

use App\Http\Controllers\NavController;
use App\Type;
use Auth;
use Closure;

class CacheMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()) {
            $links = NavController::index();
            cache(['links' => $links], now()->addMinutes(5));
        }

        if (!cache('types')) {
            $types = Type::all();
            cache(['types' => $types], now()->addMinutes(5));

            $brands = [];
            foreach ($types as $type) {
                $brands[$type->id] = $type->brands()->getResults();
            }
            cache(['marcas' => $brands], now()->addMinutes(5));
        }

        return $next($request);
    }
}
