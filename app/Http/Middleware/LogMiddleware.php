<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $route = $this->route;
        $exep = [
            'panel/asm/letters/create/search',
            'panel/automationSystem/search',
            'panel/automationSystem/addBrandToGroup'
        ];
        if ($route->methods()[0] != 'GET' && !in_array( $request->path() , $exep)) {
            $user_id = Auth::user() ? Auth::user()->id : null;
            $method = $route->getActionMethod();
            $action = explode('//' , $route->getActionName());
            $controller = substr(end($action) , 0 , strpos(end($action) , '@'));
            $log = Log::create([
                'user_id' => $user_id,
                'ip' => $request->ip(),
                'mac' => 0,
                'agent' => $request->server('HTTP_USER_AGENT'),
                'controller' =>  $controller,
                'method' => $method,
                'input' => $request->getContent(),
                'output' => null,
                'route' => $request->path(),
                'http_method' => $route->methods()[0],
                'referer'=> $request->headers->has('referer') ? parse_url($request->headers->get('referer'))['host'] : 'App',
            ]);
        }
        return $next($request);
    }
}
function getmac()
{
    $ipAddress=$_SERVER['REMOTE_ADDR'];
    $macAddr=false;

#run the external command, break output into lines
    $arp=`arp -a $ipAddress`;
    $lines=explode("\n", $arp);

#look for the output line describing our IP address
    foreach($lines as $line)
    {
        $cols=preg_split('/\s+/', trim($line));
        if ($cols[0]==$ipAddress)
        {
            $macAddr=$cols[1];
        }
    }

    return $macAddr;
}
