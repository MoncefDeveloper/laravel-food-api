<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IngredientController extends Controller
{
    public function fetchIngredients()
    {
        $response = Http::get('https://www.themealdb.com/api/json/v1/1/list.php?i=list');

        if ($response->successful()) {
            $ingredients = $response->json()['meals'];
            return response()->json($ingredients);
        } else {
            return response()->json(['error' => 'Failed to fetch ingredients'], 500);
        }
    }
}
