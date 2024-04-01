<?php
function pathsImage($path) {
    /*
    TODO remove this in production, this is just for heroku demo app to work.
    */
    $found = file_exists('images/' . $path);
    if($found) {
        return asset('images/' . $path);
    }
    // TODO leave this line in production.
    return $path && file_exists('storage/' . $path) ? asset('storage/' . $path) : asset('images/not-found.jpg');
}