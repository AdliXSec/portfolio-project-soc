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
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->logSuspiciousActivity($request);
        return $next($request);
    }

    protected function logSuspiciousActivity(Request $request)
    {
        // 1. Dapatkan semua input yang sudah di-decode oleh Laravel.
        $decodedInput = $request->all();

        // 2. Dapatkan string query mentah dan decode secara manual untuk analisis bypass.
        $rawQuery = urldecode($request->getQueryString() ?? '');

        // Abaikan field internal
        unset($decodedInput['_token']);
        unset($decodedInput['_method']);

        if (empty($decodedInput) && empty($rawQuery)) {
            return;
        }

        $payload = json_encode($decodedInput);

        // Kumpulan pola regex yang lebih komprehensif dan cerdas
        $patterns = [
            'SQLi' => [
                '/\b(union|select|insert|delete|update|drop|alter|exec|truncate|declare|char|cast|convert)\b/i',
                '/((\x27)|(\'))\s*(or|and|OR|AND)\s*((\x27)|(\'))\s*(\x3D\s*((\x27)|(\')))?/i', // ' or '1'='1
                '/--|\#|\/\*|\%23|\%2d\%2d/', // SQL comments and encoded variants
                '/\b(sleep|benchmark|load_file|outfile)\s*\(.*\)/i', // Time-based and file-based SQLi
            ],
            'XSS' => [
                '/<((%3C)?)script\b[^>]*>([\s\S]*?)<\/(%2F)?script((%3E)?)>/i', // <script> tags with encoding
                '/\b(on\w+)\s*(\x3D|%3D)/i', // on... events with encoding
                '/(javascript|vbscript|data|file)\s*:/i', // URI schemes
                '/<((%3C)?)(iframe|object|embed|applet|video|audio|style)\b[^>]*>/i', // Embeddable tags
                '/style\s*=\s*["\'][^"\'>]*expression\s*\(/i', // CSS expressions (old IE)
            ],
            'LFI' => [
                '/(\.\.\/|\.\\\\|%2e%2e%2f|%2e%2e%5c)/', // Path Traversal with encoding
                '/\b(etc\/passwd|boot\.ini)\b/i', // Common sensitive files
                '/(php|phar|zip|data)\:\/\//i', // PHP wrappers
            ],
            'SSRF' => [
                '/\b(localhost|127\.0\.0\.1|169\.254\.169\.254|\[::1\])\b/i', // Internal IPs
                '/\b(file|ftp|http|https|gopher)\:\/\/(127\.|10\.|192\.168\.|172\.(1[6-9]|2[0-9]|3[0-1]))/i', // Access to local network resources
                '/\b(metadata\.google\.internal|instance-data)\b/i', // Cloud metadata services
            ],
            'XPath' => [
                '/\b(count|string|concat|substring|starts-with|name)\s*\(/i', // XPath functions
                '/(\'|\")\s+(or|and)\s+(\'|\")\d+(\'|\")\s*\x3D\s*(\'|\")\d+(\'|\" )/i', // XPath injection like ' or '1'='1
                '/\/\*|\/text\(\)|\/node\(\)/', // Common XPath syntax
            ],
            'SSTI' => [
                '/(\{\{|\{\%|\<\%|\< #|#\[|\[\[)/', // Common template delimiters
                '/\{\{.*(self|config|settings|get|os|system|eval|exec|popen|import|builtins|globals|request|lipsum|cycler|joiner|range|dict|dump|app|session|url_for|get_flashed_messages|get_config).*\}\}/i', // Common SSTI payloads
            ],
            'Command Injection' => [
                '/\b(passthru|shell_exec|system|exec|popen|proc_open)\s*\(/i',
                '/(`|%60)[\s\S]*?(`|%60)/i', // Backticks with encoding
                '/(&|\||;)\s*(ls|dir|cat|whoami|uname|ipconfig|ifconfig)/i', // Command chaining
            ],
            'XXE' => [
                '/(<!DOCTYPE|<!ENTITY)/i', // Basic DOCTYPE or ENTITY declaration
                '/SYSTEM|PUBLIC/i', // SYSTEM or PUBLIC identifiers for external entities
                '/(\<|%3C)!ENTITY.*(file|http|ftp|php):\/\//i', // ENTITY loading external resources
            ],
        ];

        // Iterasi melalui setiap jenis serangan dan polanya
        foreach ($patterns as $type => $attackPatterns) {
            foreach ($attackPatterns as $pattern) {
                // Periksa input array yang sudah di-decode dan string query mentah
                if ($this->patternMatches($decodedInput, $pattern) || preg_match($pattern, $rawQuery)) {
                    $this->log($type, $request, $payload);
                    continue 2; // Lanjut ke jenis serangan berikutnya setelah satu ditemukan
                }
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
        // Gunakan firstOrCreate untuk menghindari duplikasi log yang sama persis dalam waktu singkat
        SecurityLog::firstOrCreate(
            [
                'ip_address' => $request->ip(),
                'path' => $request->path(),
                'type' => $type,
                'created_at' => now()->subMinutes(5) // Cek duplikat dalam 5 menit terakhir
            ],
            [
                'user_id' => Auth::id(),
                'method' => $request->method(),
                'payload' => $payload,
                'user_agent' => $request->userAgent(),
            ]
        );
    }
}