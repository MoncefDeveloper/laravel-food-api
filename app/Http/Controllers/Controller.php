<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    // public function fetchMealsByArea()
    // {

    //     $area = "Canadian";
    //     $response = Http::get('www.themealdb.com/api/json/v1/1/filter.php?a=' . $area);

    //     if ($response->successful()) {
    //         $meals = $response->json()['meals'];
    //         $meals = array_slice($meals, 0, 6);
    //         $mealDetailsArray = collect();

    //         foreach ($meals as $meal) {
    //             $response = Http::get("www.themealdb.com/api/json/v1/1/lookup.php?i={$meal['idMeal']}");

    //             if ($response->successful()) {
    //                 $mealDetails = $response->json('meals.0');

    //                 $this->PushData($mealDetailsArray, $mealDetails);
    //             } else {
    //                 return response()->json(['error' => 'Failed to fetch meal details'], 500);
    //             }
    //         }


    //         return $mealDetailsArray;
    //     } else {
    //         return response()->json(['error' => 'Failed to fetch meals'], 500);
    //     }
    // }

    // public function fetchMealsByCategory()
    // {

    //     $category = "Dessert";
    //     $response = Http::get('www.themealdb.com/api/json/v1/1/filter.php?c=' . $category);

    //     if ($response->successful()) {
    //         $meals = $response->json()['meals'];
    //         $meals = array_slice($meals, 0, 6);

    //         $mealDetailsArray = collect();

    //         foreach ($meals as $meal) {
    //             $response = Http::get("www.themealdb.com/api/json/v1/1/lookup.php?i={$meal['idMeal']}");

    //             if ($response->successful()) {
    //                 $mealDetails = $response->json('meals.0');

    //                 $this->PushData($mealDetailsArray, $mealDetails);
    //             } else {
    //                 return response()->json(['error' => 'Failed to fetch meal details'], 500);
    //             }
    //         }


    //         return $mealDetailsArray;
    //     } else {
    //         return response()->json(['error' => 'Failed to fetch meals'], 500);
    //     }
    // }

    // public function fetchMealsByIngredient()
    // {

    //     $ingredient = "chicken_breast";
    //     $response = Http::get('www.themealdb.com/api/json/v1/1/filter.php?i=' . $ingredient);

    //     if ($response->successful()) {
    //         $meals = $response->json()['meals'];
    //         $meals = array_slice($meals, 0, 6);

    //         $mealDetailsArray = collect();

    //         foreach ($meals as $meal) {
    //             $response = Http::get("www.themealdb.com/api/json/v1/1/lookup.php?i={$meal['idMeal']}");

    //             if ($response->successful()) {
    //                 $mealDetails = $response->json('meals.0');

    //                 $this->PushData($mealDetailsArray, $mealDetails);
    //             } else {
    //                 return response()->json(['error' => 'Failed to fetch meal details'], 500);
    //             }
    //         }


    //         return $mealDetailsArray;
    //     } else {
    //         return response()->json(['error' => 'Failed to fetch meals'], 500);
    //     }
    // }

    // public function fetchMealsByName()
    // {

    //     $name = "chicken";
    //     $response = Http::get('https://www.themealdb.com/api/json/v1/1/search.php?s=' . $name);

    //     if ($response->successful()) {
    //         $meals = $response->json()['meals'];
    //         $meals = array_slice($meals, 0, 6);

    //         $mealDetailsArray = collect();

    //         foreach ($meals as $mealDetails) {

    //             $this->PushData($mealDetailsArray, $mealDetails);
    //         }

    //         return $mealDetailsArray;
    //     } else {
    //         return response()->json(['error' => 'Failed to fetch meals'], 500);
    //     }
    // }

    // public function fetchMealsById()
    // {

    //     $id = "52925";
    //     $response = Http::get('www.themealdb.com/api/json/v1/1/lookup.php?i=' . $id);

    //     if ($response->successful()) {
    //         $meals = $response->json()['meals'];
    //         return $meals;
    //     } else {
    //         return response()->json(['error' => 'Failed to fetch meals'], 500);
    //     }
    // }


    // public function fetchMealsByAreaAndCategoryAndIngredient(Request $request)
    // {
    //     // $area = $request->input('area');
    //     // $category = $request->input('category');
    //     // $ingredient = $request->input('ingredient');

    //     $area = "Canadian";
    //     $category = "";
    //     $ingredient = "";

    //     $areaResponse = $area ? Http::get('www.themealdb.com/api/json/v1/1/filter.php?a=' . $area) : null;
    //     $categoryResponse = $category ? Http::get('www.themealdb.com/api/json/v1/1/filter.php?c=' . $category) : null;
    //     $ingredientResponse = $ingredient ? Http::get('www.themealdb.com/api/json/v1/1/filter.php?i=' . $ingredient) : null;

    //     $responsesSuccessful = true;
    //     $areaMeals = $categoryMeals = $ingredientMeals = [];

    //     if ($areaResponse && $areaResponse->successful()) {
    //         $areaMeals = array_column($areaResponse->json()['meals'], 'idMeal');
    //     } elseif ($areaResponse) {
    //         $responsesSuccessful = false;
    //     }

    //     if ($categoryResponse && $categoryResponse->successful()) {
    //         $categoryMeals = array_column($categoryResponse->json()['meals'], 'idMeal');
    //     } elseif ($categoryResponse) {
    //         $responsesSuccessful = false;
    //     }

    //     if ($ingredientResponse && $ingredientResponse->successful()) {
    //         $ingredientMeals = array_column($ingredientResponse->json()['meals'], 'idMeal');
    //     } elseif ($ingredientResponse) {
    //         $responsesSuccessful = false;
    //     }

    //     if (!$responsesSuccessful) {
    //         return response()->json(['error' => 'Failed to fetch meals'], 500);
    //     }

    //     $mealIds = [];

    //     if ($area && $category && $ingredient) {
    //         $mealIds = array_intersect($areaMeals, $categoryMeals, $ingredientMeals);
    //     } elseif ($area && $category) {
    //         $mealIds = array_intersect($areaMeals, $categoryMeals);
    //     } elseif ($area && $ingredient) {
    //         $mealIds = array_intersect($areaMeals, $ingredientMeals);
    //     } elseif ($category && $ingredient) {
    //         $mealIds = array_intersect($categoryMeals, $ingredientMeals);
    //     } elseif ($area) {
    //         $mealIds = $areaMeals;
    //     } elseif ($category) {
    //         $mealIds = $categoryMeals;
    //     } elseif ($ingredient) {
    //         $mealIds = $ingredientMeals;
    //     }

    //     $mealDetailsArray = collect();

    //     foreach (array_slice($mealIds, 0, 6) as $mealId) {
    //         $mealResponse = Http::get("www.themealdb.com/api/json/v1/1/lookup.php?i=$mealId");

    //         if ($mealResponse->successful() && $mealResponse->hasHeader('Content-Type', 'application/json')) {
    //             $mealDetails = $mealResponse->json('meals.0');

    //             $mealDetailsArray->push([
    //                 'idMeal' => $mealDetails['idMeal'],
    //                 'strMeal' => $mealDetails['strMeal'],
    //                 'strCategory' => $mealDetails['strCategory'],
    //                 'strArea' => $mealDetails['strArea'],
    //                 'strMealThumb' => $mealDetails['strMealThumb'],
    //                 'strIngredient1' => $mealDetails['strIngredient1'],
    //                 'strIngredient2' => $mealDetails['strIngredient2'],
    //                 'strIngredient3' => $mealDetails['strIngredient3'],
    //                 'strMeasure1' => $mealDetails['strMeasure1'],
    //                 'strMeasure2' => $mealDetails['strMeasure2'],
    //                 'strMeasure3' => $mealDetails['strMeasure3'],
    //             ]);
    //         } else {
    //             // Handle error here
    //             // You can log the error or throw an exception
    //         }
    //     }

    //     return $mealDetailsArray;
    // }
    // }

}
