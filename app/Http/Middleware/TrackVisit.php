<?php

namespace App\Http\Middleware;

use App\Models\SiteVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldTrack($request)) {
            $this->recordVisit($request);
        }

        return $response;
    }

    private function shouldTrack(Request $request): bool
    {
        // Only track GET and POST on web routes, skip assets/api/admin
        if ($request->is('admin/*', 'webhook/*', '_debugbar/*', 'livewire/*')) {
            return false;
        }

        if (! in_array($request->method(), ['GET', 'POST'])) {
            return false;
        }

        // Skip asset requests
        $path = $request->path();
        if (preg_match('/\.(css|js|ico|png|jpg|jpeg|gif|svg|woff2?|ttf|eot|map)$/i', $path)) {
            return false;
        }

        return true;
    }

    private function recordVisit(Request $request): void
    {
        $pageType = $this->determinePageType($request);

        try {
            SiteVisit::create([
                'ip_address' => $request->ip(),
                'url' => substr($request->fullUrl(), 0, 2048),
                'method' => $request->method(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 1024),
                'referer' => $request->header('referer') ? substr($request->header('referer'), 0, 2048) : null,
                'session_id' => $request->session()->getId(),
                'email' => $request->input('email') ?: $request->input('email_satusehat'),
                'order_uuid' => $request->route('order')?->uuid ?? null,
                'order_status' => $request->route('order')?->status ?? null,
                'page_type' => $pageType,
            ]);
        } catch (\Throwable $e) {
            // Silently fail - tracking should never break the site
            Log::debug('TrackVisit error: '.$e->getMessage());
        }
    }

    private function determinePageType(Request $request): ?string
    {
        $path = $request->path();

        if ($path === '/' || $path === '') {
            return 'home';
        }
        if (str_starts_with($path, 'registrasi')) {
            return $request->isMethod('POST') ? 'registration_submit' : 'registration';
        }
        if (str_starts_with($path, 'pembayaran')) {
            return 'payment';
        }
        if (str_starts_with($path, 'tiket')) {
            return 'ticket';
        }
        if (str_starts_with($path, 'artikel')) {
            return 'article';
        }
        if (str_starts_with($path, '3mpc')) {
            return '3mpc';
        }

        return 'other';
    }
}
