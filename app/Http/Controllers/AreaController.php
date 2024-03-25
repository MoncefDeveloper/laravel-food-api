<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function fetchAreas()
    {
        $response = Http::get('https://www.themealdb.com/api/json/v1/1/list.php?a=list');

        if ($response->successful()) {
            $areas = $response->json()['meals'];
            return response()->json($areas);
        } else {
            return response()->json(['error' => 'Failed to fetch areas'], 500);
        }
    }
}
