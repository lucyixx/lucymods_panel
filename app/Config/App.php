<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    // public string $baseURL = 'http://localhost:8080/';
    public string $baseURL = 'https://lucy.sryze.cc';
    public array $allowedHostnames = [];
    public string $indexPage = '';
    public string $uriProtocol = 'REQUEST_URI';
    public string $defaultLocale = 'en';
    public bool $negotiateLocale = false;
    public array $supportedLocales = ['en', 'vi'];
    public string $appTimezone = 'UTC';
    public string $charset = 'UTF-8';
    public array $proxyIPs = [];
    // public bool $CSPEnabled = false;
    
    
    // Đường dẫn gốc
    // public string $baseURL = 'https://zygama.click';

    // Nếu không dùng index.php thì set rỗng (kết hợp .htaccess)
    // public string $indexPage = '';

    // URL an toàn
    // public string $uriProtocol = 'REQUEST_URI';

    // Charset chuẩn
    // public string $charset = 'UTF-8';

    /**
     * CSRF Protection.
     */
    public bool   $CSRFProtect  = true;               // bật CSRF
    public string $CSRFTokenName = 'csrf_token';      // tên token
    public string $CSRFHeaderName = 'X-CSRF-TOKEN';   // header dùng cho AJAX
    public string $CSRFCookieName = 'csrf_cookie';    // tên cookie lưu token
    public int    $CSRFExpire   = 7200;               // thời gian sống 2h
    public bool   $CSRFRegenerate = true;             // regenerate token mỗi request
    public bool   $CSRFRedirect = false;              // không redirect khi lỗi

    /**
     * Cookie bảo mật.
     */
    public string $cookiePrefix   = 'ci4_';           // prefix để tránh xung đột
    public string $cookieDomain   = 'lucy.sryze.cc';   // chỉ domain chính
    public string $cookiePath     = '/';              // áp dụng toàn bộ site
    public string $cookieSameSite = 'Strict';         // Strict để chống CSRF từ site khác
    public bool   $cookieSecure   = true;             // chỉ gửi cookie qua HTTPS
    public bool   $cookieHTTPOnly = true;             // chặn JS truy cập cookie

    /**
     * Session bảo mật.
     */
    public string $sessionDriver        = 'CodeIgniter\Session\Handlers\DatabaseHandler'; // lưu session trong DB
    public string $sessionCookieName    = 'ci4_session';
    public int    $sessionExpiration    = 7200;      // session 2h
    public string $sessionSavePath      = 'ci_sessions'; // bảng DB lưu session
    public bool   $sessionMatchIP       = true;      // check IP để chống session hijacking
    public bool   $sessionRegenerateDestroy = true;  // hủy session cũ khi regenerate

    public bool $CSPEnabled = true;                  // bật CSP để hạn chế XSS
    public bool $forceGlobalSecureRequests = true; // ép HTTPS cho toàn site
    
    public function __construct()
    {
        parent::__construct();

        $this->baseURL = $this->detectBaseURL();
    }

    protected function detectBaseURL(): string
    {
        // Giao thức (http hoặc https)
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
            ? "https://" : "http://";

        // Host và port
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

        // Nếu bạn muốn thêm đường dẫn con (nếu site không nằm ở root)
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $path = str_replace(basename($scriptName), '', $scriptName);

        return $protocol . $host . $path;
    }

}
