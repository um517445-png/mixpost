<?php

use Illuminate\Support\HtmlString;

if (! function_exists('mixpostAssets')) {
    function mixpostAssets(): HtmlString
    {
        $hot = __DIR__.'/../resources/dist/hot';

        $devServerIsRunning = file_exists($hot);

        if ($devServerIsRunning) {
            $viteServer = file_get_contents($hot);

            return new HtmlString(<<<HTML
                <script type=module src=$viteServer/@vite/client></script>
                <script type=module src=$viteServer/resources/js/app.js></script>
            HTML
            );
        }

        // Use pre-built assets from CDN
        $cdnBase = '';
        $jsFile  = 'assets/app-DoZI0dqj.js';
        $cssFile = 'assets/app-CSJ7On8s.css';

        // Check local manifest first (if available)
        $manifestPath = public_path('vendor/mixpost/manifest.json');
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            if (isset($manifest['resources/js/app.js'])) {
                $jsFile  = $manifest['resources/js/app.js']['file'];
                $cssFile = $manifest['resources/js/app.js']['css'][0] ?? $cssFile;
                $cdnBase = ''; // Use local files
            }
        }

        $jsUrl  = $cdnBase ? {}/vendor/mixpost/{$jsFile} : /vendor/mixpost/{$jsFile};
        $cssUrl = $cdnBase ? {}/vendor/mixpost/{$cssFile} : /vendor/mixpost/{$cssFile};

        return new HtmlString(<<<HTML
                <script type=module src=$jsUrl></script>
                <link rel=stylesheet href=$cssUrl>
            HTML
        );
    }
}
