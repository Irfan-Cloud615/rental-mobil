<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

/**
 * Forces HTTPS asset/url generation and instructs the browser to upgrade
 * any insecure (http://) subresource request to https://. This eliminates
 * "Mixed Content: Active content blocked" errors on HTTPS-only hosts like
 * Railway, where the app is served behind a TLS-terminating proxy.
 */
class ForceSecureContent
{
  /**
   * Handle an incoming request.
   */
  public function handle(Request $request, Closure $next)
  {
    // Detect HTTPS either because the request itself is secure (via
    // X-Forwarded-Proto handled by TrustProxies) or because the app is
    // configured to always require HTTPS in production.
    $forceHttps = $request->isSecure()
      || app()->environment('production')
      || filter_var(config('app.force_https', env('FORCE_HTTPS', false)), FILTER_VALIDATE_BOOLEAN);

    if ($forceHttps) {
      URL::forceScheme('https');

      // Make session cookie + redirects HTTPS-safe as well.
      config(['session.secure' => true]);
      $request->headers->set('X-Forwarded-Proto', 'https');
    }

    /** @var \Symfony\Component\HttpFoundation\Response $response */
    $response = $next($request);

    // Header-based CSP is respected regardless of where it is emitted, unlike
    // a <meta http-equiv> tag which is ignored outside <head>. This forces
    // the browser to rewrite every http:// subresource (JS, CSS, images,
    // iframes, XHR) to https:// instead of blocking it as mixed content.
    $response->headers->set('Content-Security-Policy', 'upgrade-insecure-requests');

    if ($forceHttps) {
      $response->headers->set('Strict-Transport-Security', 'max-age=15552000; includeSubDomains');
    }

    return $response;
  }
}
