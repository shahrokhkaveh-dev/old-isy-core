<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;

class TrackVisitsMiddleware
{
    protected $bots = [
        'Googlebot',
        'Bingbot',
        'Slurp',
        'DuckDuckBot',
        'Baiduspider',
        'YandexBot',
        'Sogou',
        'Exabot',
        'facebot',
        'facebookexternalhit',
        'ia_archiver',
    ];

    public function handle(Request $request, Closure $next)
    {
        $userAgent = $request->userAgent();

        //dont save visits from bots
        if (in_array($userAgent, $this->bots, true)) {
            return $next($request);
        }

        $ip = $request->ip();
        $url = $request->fullUrl();

        $existingVisit = Visit::where('ip_address', $ip)
//            ->where('url',$url)
            ->today()
            ->first();

        if(!$existingVisit){
            Visit::create([
                'ip_address' => $ip,
                'url' => $url,
                'user_agent' => $request->userAgent(),
            ]);
        }
        return $next($request);
    }
}
