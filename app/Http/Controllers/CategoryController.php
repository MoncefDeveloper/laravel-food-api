<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    public function fetchCategories()
    {
        $response = Http::get('https://www.themealdb.com/api/json/v1/1/list.php?c=list');

        if ($response->successful()) {
            $categories = $response->json()['meals'];
            return response()->json($categories);
        } else {
            return response()->json(['error' => 'Failed to fetch categories'], 500);
        }
    }
}
