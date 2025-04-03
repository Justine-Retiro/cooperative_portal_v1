<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function proxyRequest(Request $request)
    {
        $url = 'https://maps.googleapis.com/maps/api/js?key=' . env('GOOGLE_MAPS_API_KEY') . '&libraries=places';
        $response = file_get_contents($url);
        return response($response);
    }
}
