<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetRequestMode
{
    /**
     * لیست مقادیر مجاز برای Mode
     */
    protected $allowedModes = ['global', 'freezone'];
    /**
     * هندل کردن درخواست ورودی و تنظیم Mode در container
     *
     * اگر مقدار هدر X-Mode معتبر باشد، استفاده می‌شود.
     * در غیر این صورت، مقدار پیش‌فرض 'global' تنظیم خواهد شد.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(Request): Response  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // خواندن و آماده‌سازی مقدار mode از header
        $mode = strtolower(trim((string) $request->header('X-Mode', 'global')));

        // اگر mode مجاز نبود، مقدار پیش‌فرض را تنظیم کن
        if(!in_array($mode, $this->allowedModes, true)){
            $mode = 'global';
        }

        // ثبت mode در container برای استفاده در طول lifecycle درخواست
        app()->instance('request_mode', $mode);

        return $next($request);
    }
}
