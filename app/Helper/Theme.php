<?php

if (!function_exists('theme_image')) {
    function theme_image($filename, $theme = null) {
        
        $theme = $theme ?? config('app.theme', 'default');

        $themePath = public_path("themes/{$theme}/images/{$filename}");
        $defaultPath = public_path("themes/default/images/{$filename}");

        if (file_exists($themePath)) {
            return asset("themes/{$theme}/images/{$filename}");
        } elseif (file_exists($defaultPath)) {
            return asset("themes/default/images/{$filename}");
        }

        return null; // Or theme_image('placeholder.png')
    }
}

if (!function_exists('theme_view')) {
    function theme_view($view, $data = [], $mergeData = [], $theme = null) {
        $theme = $theme ?? config('app.theme', 'default');
        $themeViewPath = 'themes.' . $theme . '.' . $view;
        $defaultViewPath = 'themes.default.' . $view;
        // dd($themeViewPath, View::exists($themeViewPath));
        if (View::exists($themeViewPath)) {
            // return view($themeViewPath, $data, $mergeData);
            return $themeViewPath;
        }
        return $defaultViewPath;
        // return view($defaultViewPath, $data, $mergeData);
    }

}
