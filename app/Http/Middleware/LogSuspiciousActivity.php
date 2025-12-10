<?php

namespace App\Http\Middleware;

use App\Models\SecurityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogSuspiciousActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->logSuspiciousActivity($request);
        return $next($request);
    }

    protected function logSuspiciousActivity(Request $request)
    {
        $input = $request->all();

        // Exclude Laravel's internal fields from logging
        unset($input['_token']);
        unset($input['_method']);

        if (empty($input)) {
            return;
        }

        $payload = json_encode($input);

        // Define suspicious patterns
        $sqlPatterns = [
            '/(\'|")\s*(or|and)\s*(\'|")\s*(\'|")\s*=\s*(\'|")/', // ' or ' = '
            '/\b(union|select|insert|delete|update|drop|alter)\b/i',
            '/--|\#|\/\*/', // SQL comments
        ];

        $xssPatterns = [
            '/<script\b[^>]*>([\s\S]*?)<\/script>/i',
            '/\b(on\w+)\s*=/i', // onload, onerror, etc.
            '/javascript\s*:/i',
        ];

        // Check for SQLi
        foreach ($sqlPatterns as $pattern) {
            if ($this->patternMatches($input, $pattern)) {
                $this->log('SQLi', $request, $payload);
                break; // Log once per request for this type
            }
        }

        // Check for XSS
        foreach ($xssPatterns as $pattern) {
            if ($this->patternMatches($input, $pattern)) {
                $this->log('XSS', $request, $payload);
                break; // Log once per request for this type
            }
        }
    }

    protected function patternMatches(array $input, string $pattern): bool
    {
        foreach ($input as $key => $value) {
            if (is_string($value) && preg_match($pattern, $value)) {
                return true;
            }
            if (is_array($value) && $this->patternMatches($value, $pattern)) {
                return true;
            }
        }
        return false;
    }

    protected function log(string $type, Request $request, string $payload)
    {
        SecurityLog::create([
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'path' => $request->path(),
            'method' => $request->method(),
            'payload' => $payload,
            'type' => $type,
            'user_agent' => $request->userAgent(),
        ]);
    }
}
