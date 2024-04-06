<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetAppLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Header: Accept-Language
        /*$default = 'en';
        $language = $request->header('accept-language');
        if ($language) {
            $options = explode(',', $language);
            $default = $options[0];
            if (strlen($default) == 5) {
                $default = substr($default, 0, 2);
            }
        }
        $lang = $request->input('lang', Session::get('locale', $default));
        App::setLocale($lang);
        Session::put('locale', $lang);    تخزين قيمة ال لنج داخل السشن */  

        $locale = $request->route('locale', 'en'); // بقرائة قيمة ال روات داخل براتر صفحة ويب دوت بي اتش بي  باستخدام هذه الدالة بقرائة القيمة
        URL::defaults([
            'locale' => $locale,
        ]);
        Route::current()->forgetParameter('locale');

        App::setLocale($locale);

        return $next($request);
    }
}
