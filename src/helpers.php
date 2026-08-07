<?php

use Illuminate\Support\HtmlString;

if (! function_exists('mixpostAssets')) {
    function mixpostAssets(): HtmlString
    {
        $hot = __DIR__.'/../resources/dist/hot';

        if (file_exists($hot)) {
            $viteServer = trim(file_get_contents($hot));
            return new HtmlString(
                '<script type="module" src="'.$viteServer.'/@vite/client"></script>'.
                '<script type="module" src="'.$viteServer.'/resources/js/app.js"></script>'
            );
        }

        // CDN base for pre-built assets
        $cdn     = 'https://mixpost-cloud-rfn8x7ino-veyra10.vercel.app';
        $jsFile  = 'assets/app-DoZI0dqj.js';
        $cssFile = 'assets/app-CSJ7On8s.css';

        // Try local manifest first
        $manifestPath = public_path('vendor/mixpost/manifest.json');
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            if (isset($manifest['resources/js/app.js'])) {
                $entry   = $manifest['resources/js/app.js'];
                $jsFile  = $entry['file'];
                $cssFile = isset($entry['css'][0]) ? $entry['css'][0] : $cssFile;
                $cdn     = ''; // use local path
            }
        }

        $base   = $cdn ? $cdn.'/vendor/mixpost' : '/vendor/mixpost';
        $jsUrl  = $base.'/'.$jsFile;
        $cssUrl = $base.'/'.$cssFile;

        return new HtmlString(
            '<script type="module" src="'.$jsUrl.'"></script>'.
            '<link rel="stylesheet" href="'.$cssUrl.'">'
        );
    }
}
