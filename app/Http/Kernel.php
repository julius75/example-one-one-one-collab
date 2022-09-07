<?php

namespace Dervis\Http;

use Dervis\Http\Middleware\EncryptCookies;
use Dervis\Http\Middleware\RedirectIfAuthenticated;
use Dervis\Http\Middleware\VerifyCsrfToken;
use Ignite\Deploy\Http\Middleware\DeployMiddleware;
use Ignite\Users\Http\Middleware\FacilityMiddleware;
use Ignite\Users\Http\Middleware\RegionMiddleware;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Maatwebsite\Sidebar\Middleware\ResolveSidebars;

class Kernel extends HttpKernel {

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        ShareErrorsFromSession::class,
        \Barryvdh\Cors\HandleCors::class,
        VerifyCsrfToken::class,
        \Dervis\Http\Middleware\TransformsRequest::class,
        \Dervis\Http\Middleware\TrimStrings::class,
        \Dervis\Http\Middleware\ConvertEmptyStringsToNull::class,
        ResolveSidebars::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ],
        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'region' => RegionMiddleware::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'throttle' => ThrottleRequests::class,
        'facility' => FacilityMiddleware::class
    ];

}
