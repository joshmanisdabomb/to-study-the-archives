<?php

namespace App\Http\Middleware;

use App\Models\PageTraffic;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageTrafficMiddleware {

    public function handle(Request $request, Closure $next) {
        PageTraffic::updateOrCreate(['page' => $request->path()], ['counter' => DB::raw('counter + 1')]);
        return $next($request);
    }

}
