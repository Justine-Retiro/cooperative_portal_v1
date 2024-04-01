<?php

namespace App\Helpers;

class AssetHelper
{
    /**
     * Generate a URL for an asset from a storage path.
     *
     * @param string $path The storage path of the asset.
     * @return string
     */
    public static function assetFromStorage($path)
    {
        // Remove the 'public/' prefix if present, as 'storage/' will be used instead.
        $correctPath = str_replace('public/', '', $path);
        // Generate the asset URL.
        return asset('storage/' . $correctPath);
    }
}