<?php
if (!function_exists('theme_config')) {
    function theme_config($key) {
        return config('theme.' . config('app.theme') . '.' . $key);
    }

}

if (!function_exists('theme_image')) {
    function theme_image($filename, $theme = null) {
        
        $theme = $theme ?? config('app.theme', 'default');

        $themeImagePath = "{$theme}/images/{$filename}";
        $defaultImagePath = "default/images/{$filename}";

        if (Storage::disk('themes')->exists($themeImagePath)) {
            return asset("themes/{$theme}/images/{$filename}");
        } elseif (Storage::disk('themes')->exists($defaultImagePath)) {
            return asset("themes/default/images/{$filename}");
        }

        return null; // Or theme_image('placeholder.png')
    }
}

if (!function_exists('theme_view')) {
    function theme_view($view, /*$data = [], $mergeData = [],*/ $theme = null) {
        $theme = $theme ?? config('app.theme', 'default');
        $themeViewPath = 'themes.' . $theme . '.' . $view;
        $defaultViewPath = 'themes.default.' . $view;
        
        if (View::exists($themeViewPath)) {
            return $themeViewPath;
        }
        return $defaultViewPath;
    }

}
