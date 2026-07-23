<?php

namespace Config;

use App\Filters\AuthFilter;
use App\Filters\AdminFilter;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array<string, class-string|list<class-string>> [filter_name => classname]
     *                                                     or [filter_name => [classname1, classname2, ...]]
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
		'auth'          => AuthFilter::class,
		'admin'         => AdminFilter::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array<string, array<string, array<string, string>>>|array<string, list<string>>
     */
    public array $globals = [
        'before' => [
			'csrf' => [
				// keys/api is a read-only (SELECT-only) listing endpoint used by
				// DataTables server-side processing. It is switched to POST in
				// app/Views/Keys/list.php to avoid some hosts' WAF/nginx blocking
				// long bracket-style query strings (e.g. columns[0][data]=...),
				// so it is exempted from CSRF like any other safe, idempotent read.
				'except' => ['connect', 'keys/api'],
			],
			'auth' => [
				'except' => [
					'/', 'login', 'register', 'connect', 'keys/free', 'keys/free/recreate',  'games/details'
				]
			],
        ],
        'after' => [
            'toolbar',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don't expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [];
}
