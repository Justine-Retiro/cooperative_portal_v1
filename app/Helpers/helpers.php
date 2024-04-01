<?php

if (!function_exists('imagePath')) {
    function imagePath($path)
    {
        return $path && file_exists(public_path($path)) 
            ? asset($path) 
            : asset('img/not-found.jpg');
    }
}