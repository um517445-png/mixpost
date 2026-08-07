<?php

// ============================================================
// VENDOR ASSET PROXY: serve mixpost compiled assets from CDN
// ============================================================
$uri = $_SERVER['REQUEST_URI'] ?? '';
if (strncmp($uri, '/vendor/mixpost/', 16) === 0) {
    $cdnBase = '';
    $cdnUrl  = $cdnBase . $uri;
    $ctx = stream_context_create(['http' => [
        'timeout'         => 10,
        'follow_location' => true,
    ]]);
    $body = @file_get_contents($cdnUrl, false, $ctx);
    if ($body !== false) {
        $ext  = strtolower(pathinfo($uri, PATHINFO_EXTENSION));
        $mime = match ($ext) {
            'js'    => 'application/javascript; charset=utf-8',
            'css'   => 'text/css; charset=utf-8',
            'json'  => 'application/json',
            'woff2' => 'font/woff2',
            'woff'  => 'font/woff',
            'svg'   => 'image/svg+xml',
            'png'   => 'image/png',
            default => 'application/octet-stream',
        };
        header('Content-Type: ' . $mime);
        header('Cache-Control: public, max-age=31536000, immutable');
        header('Access-Control-Allow-Origin: *');
        echo $body;
        exit;
    }
}
// ============================================================

try {
    if (!is_dir('/tmp/cache')) {
        @mkdir('/tmp/cache', 0777, true);
    }
    if (!is_dir('/tmp/storage/framework/views')) {
        @mkdir('/tmp/storage/framework/views', 0777, true);
    }
    if (!is_dir('/tmp/storage/framework/sessions')) {
        @mkdir('/tmp/storage/framework/sessions', 0777, true);
    }

    require __DIR__ . '/../vendor/autoload.php';

    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $app->bootstrapWith([
        \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ]);

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );

    $response->send();

    try {
        $kernel->terminate($request, $response);
    } catch (\Throwable $e) {
        // Suppress non-fatal post-response termination log errors
    }
} catch (\Throwable $e) {
    if (!isset($response)) {
        http_response_code(500);
        header('Content-Type: text/html');
        echo "<div style='font-family:sans-serif; padding:20px; background:#fff0f0; border:2px solid #ff0000; border-radius:8px;'>";
        echo "<h2 style='color:#c00;'>🚨 Laravel Serverless Diagnostic Exception:</h2>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " <strong>Line:</strong> " . $e->getLine() . "</p>";
        echo "<pre style='background:#1e1e1e; color:#00ff00; padding:15px; overflow:auto; max-height:400px;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        echo "</div>";
    }
}
