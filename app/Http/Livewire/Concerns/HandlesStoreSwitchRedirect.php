<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Livewire\Redirector as LivewireRedirector;

trait HandlesStoreSwitchRedirect
{
    private function redirectToReferrer(
        bool $redirectScanRoutesToDashboard = false,
        bool $collapseAuditDetailRoutes = false,
        bool $redirectSettingsRoutesToGlobal = false,
        bool $redirectGlobalSettingsRoutesToSettings = false
    ): RedirectResponse|LivewireRedirector {
        $fallback = route('dealer.dashboard');
        $requestHost = request()->getHost();
        $candidates = [
            request()->headers->get('referer'),
            url()->previous(),
        ];

        foreach ($candidates as $candidate) {
            if (! is_string($candidate)) {
                continue;
            }
            if ($candidate === '') {
                continue;
            }
            $candidateHost = parse_url($candidate, PHP_URL_HOST);
            if (! is_string($candidateHost)) {
                continue;
            }
            if ($candidateHost !== $requestHost) {
                continue;
            }

            if ($collapseAuditDetailRoutes) {
                $candidate = $this->collapseAuditPath($candidate);
                $candidate = $this->collapseEmployeePath($candidate);
            }

            if ($redirectScanRoutesToDashboard && $this->isScanPath($candidate)) {
                return redirect()->to($fallback);
            }
            if ($redirectSettingsRoutesToGlobal && $this->shouldRedirectSettingsToGlobal($candidate)) {
                return redirect()->route('dealer.settings.global');
            }
            if ($redirectGlobalSettingsRoutesToSettings && $this->isGlobalSettingsPath($candidate)) {
                return redirect()->route('dealer.dealer.settings');
            }

            return redirect()->to($candidate);
        }

        return redirect()->to($fallback);
    }

    private function isScanPath(string $url): bool
    {
        $path = parse_url($url, PHP_URL_PATH);

        if (! is_string($path) || $path === '') {
            return false;
        }

        $trimmedPath = trim(ltrim($path, '/'), '/');
        if ($trimmedPath === 'scans') {
            return true;
        }
        if (Str::startsWith($trimmedPath, 'scans/')) {
            return true;
        }
        if ($trimmedPath === 'scans-archive') {
            return true;
        }
        if (Str::endsWith($trimmedPath, '/scans')) {
            return true;
        }

        return Str::contains($trimmedPath, '/scans/');
    }

    private function shouldRedirectSettingsToGlobal(string $url): bool
    {
        if (! $this->isSettingsPath($url)) {
            return false;
        }

        $user = auth()->user();

        return $user instanceof User
            && $user->hasRole('super-admin')
            && $this->hasMultipleAccessibleStores($user);
    }

    private function isSettingsPath(string $url): bool
    {
        $path = parse_url($url, PHP_URL_PATH);

        if (! is_string($path) || $path === '') {
            return false;
        }

        $trimmedPath = trim(ltrim($path, '/'), '/');

        if ($trimmedPath === 'settings') {
            return true;
        }

        return Str::startsWith($trimmedPath, 'settings/');
    }

    private function isGlobalSettingsPath(string $url): bool
    {
        $path = parse_url($url, PHP_URL_PATH);

        if (! is_string($path) || $path === '') {
            return false;
        }

        $trimmedPath = trim(ltrim($path, '/'), '/');

        if ($trimmedPath === 'global-settings') {
            return true;
        }

        return Str::startsWith($trimmedPath, 'global-settings/');
    }

    private function collapseAuditPath(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);

        if (! is_string($path) || $path === '') {
            return $url;
        }

        $segments = array_values(array_filter(explode('/', trim($path, '/'))));

        if (count($segments) < 3 || $segments[0] !== 'audits') {
            return $url;
        }

        if (! in_array($segments[1], ['osha', 'body-shop', 'finance', 'deal-jackets', 'deal-jackets-archived'], true)) {
            return $url;
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);
        $host = parse_url($url, PHP_URL_HOST);
        $port = parse_url($url, PHP_URL_PORT);
        $collapsedPath = '/audits/'.$segments[1];

        if (! is_string($scheme) || ! is_string($host)) {
            return $collapsedPath;
        }

        $authority = $host.(is_int($port) ? ':'.$port : '');

        return "{$scheme}://{$authority}{$collapsedPath}";
    }

    private function collapseEmployeePath(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);

        if (! is_string($path) || $path === '') {
            return $url;
        }

        $segments = array_values(array_filter(explode('/', trim($path, '/'))));

        if (count($segments) < 2 || $segments[0] !== 'employees') {
            return $url;
        }

        if (in_array($segments[1], ['create', 'open-invites', 'deleted'], true)) {
            return $url;
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);
        $host = parse_url($url, PHP_URL_HOST);
        $port = parse_url($url, PHP_URL_PORT);

        if (! is_string($scheme) || ! is_string($host)) {
            return '/employees';
        }

        $authority = $host.(is_int($port) ? ':'.$port : '');

        return "{$scheme}://{$authority}/employees";
    }

    private function hasMultipleAccessibleStores(User $user): bool
    {
        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            return Store::query()->count() > 1;
        }

        return $user->stores()->count() > 1;
    }
}
