<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Stores the default settings for the ContentSecurityPolicy, if you
 * choose to use it. The values here will be read in and set as defaults
 * for the site. If needed, they can be overridden on a page-by-page basis.
 *
 * Suggested reference for explanations:
 *
 * @see https://www.html5rocks.com/en/tutorials/security/content-security-policy/
 */
class ContentSecurityPolicy extends BaseConfig
{
    // -------------------------------------------------------------------------
    // Broadbrush CSP management
    // -------------------------------------------------------------------------

    /**
     * Default CSP report context
     */
    public bool $reportOnly = false;

    /**
     * Specifies a URL where a browser will send reports
     * when a content security policy is violated.
     */
    public ?string $reportURI = null;

    /**
     * Instructs user agents to rewrite URL schemes, changing
     * HTTP to HTTPS. This directive is for websites with
     * large numbers of old URLs that need to be rewritten.
     */
    public bool $upgradeInsecureRequests = false;

    // -------------------------------------------------------------------------
    // Sources allowed
    // NOTE: once you set a policy to 'none', it cannot be further restricted
    // -------------------------------------------------------------------------

    /**
     * Will default to self if not overridden
     *
     * @var string|string[]|null
     */
    public $defaultSrc;

    /**
     * Lists allowed scripts' URLs.
     *
     * NOTE: Layout dùng jQuery/Bootstrap/SweetAlert2/DataTables tải từ CDN,
     * nên phải whitelist đúng domain thay vì tắt CSP. Không thêm 'unsafe-inline'
     * ở đây — các <script> viết tay trong view đã được gắn nonce riêng
     * (xem csp_script_nonce()).
     *
     * @var string|string[]
     */
    public $scriptSrc = [
        'self',
        'code.jquery.com',
        'cdn.jsdelivr.net',
        'cdnjs.cloudflare.com',
        'cdn.datatables.net',
    ];

    /**
     * Lists allowed stylesheets' URLs.
     *
     * NOTE: 'unsafe-inline' bắt buộc phải giữ vì các view đang dùng rất nhiều
     * thuộc tính style="" nội tuyến (style attribute không nhận nonce theo
     * chuẩn CSP). Rủi ro thấp hơn nhiều so với script-src nên chấp nhận được.
     *
     * @var string|string[]
     */
    public $styleSrc = [
        'self',
        'unsafe-inline',
        'fonts.googleapis.com',
        'cdn.jsdelivr.net',
        'cdnjs.cloudflare.com',
        'cdn.datatables.net',
    ];

    /**
     * Defines the origins from which images can be loaded.
     *
     * @var string|string[]
     */
    public $imageSrc = [
        'self',
        'data:',
        'avatars.githubusercontent.com',
        'play-lh.googleusercontent.com',
    ];

    /**
     * Restricts the URLs that can appear in a page's `<base>` element.
     *
     * Will default to self if not overridden
     *
     * @var string|string[]|null
     */
    public $baseURI;

    /**
     * Lists the URLs for workers and embedded frame contents
     *
     * @var string|string[]
     */
    public $childSrc = 'self';

    /**
     * Limits the origins that you can connect to (via XHR,
     * WebSockets, and EventSource).
     *
     * @var string|string[]
     */
    public $connectSrc = 'self';

    /**
     * Specifies the origins that can serve web fonts.
     *
     * @var string|string[]
     */
    public $fontSrc = [
        'self',
        'fonts.gstatic.com',
        'cdn.jsdelivr.net',
    ];

    /**
     * Lists valid endpoints for submission from `<form>` tags.
     *
     * @var string|string[]
     */
    public $formAction = 'self';

    /**
     * Specifies the sources that can embed the current page.
     * This directive applies to `<frame>`, `<iframe>`, `<embed>`,
     * and `<applet>` tags. This directive can't be used in
     * `<meta>` tags and applies only to non-HTML resources.
     *
     * @var string|string[]|null
     */
    public $frameAncestors;

    /**
     * The frame-src directive restricts the URLs which may
     * be loaded into nested browsing contexts.
     *
     * @var array|string|null
     */
    public $frameSrc;

    /**
     * Restricts the origins allowed to deliver video and audio.
     *
     * NOTE: trang chủ có video hero load từ www.callofduty.com — nếu để trống,
     * media-src sẽ rơi về default-src 'self' và bị CSP chặn (hộp trống không
     * hiện video).
     *
     * @var string|string[]|null
     */
    public $mediaSrc = [
        'self',
        'www.callofduty.com',
    ];

    /**
     * Allows control over Flash and other plugins.
     *
     * @var string|string[]
     */
    public $objectSrc = 'self';

    /**
     * @var string|string[]|null
     */
    public $manifestSrc;

    /**
     * Limits the kinds of plugins a page may invoke.
     *
     * @var string|string[]|null
     */
    public $pluginTypes;

    /**
     * List of actions allowed.
     *
     * @var string|string[]|null
     */
    public $sandbox;

    /**
     * Nonce tag for style
     */
    public string $styleNonceTag = '{csp-style-nonce}';

    /**
     * Nonce tag for script
     */
    public string $scriptNonceTag = '{csp-script-nonce}';

    /**
     * Replace nonce tag automatically
     */
    public bool $autoNonce = true;
}