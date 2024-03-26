<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MealController extends Controller
{
    use GeneralTrait;

    public function fetchMealsByArea(Request $request)
    {
        $area = $request->input('area');
        return $this->returnData('', 'meals', $this->fetchMeals('a', $area));
    }

    public function fetchMealsByCategory(Request $request)
    {
        $category = $request->input('category');
        return $this->returnData('', 'meals', $this->fetchMeals('c', $category));
    }

    public function fetchMealsByIngredient()
    {
        return $this->fetchMeals('i', 'chicken_breast');
    }

    public function fetchMealById(Request $request)
    {
        $id = $request->input('id');
        return $this->returnData('', 'meal', $this->fetchMealDetails($id));
    }

    public function fetchMealsByAreaAndCategoryAndIngredient(Request $request)
    {
        $area = $request->input('area');
        $category = $request->input('category');
        $ingredient = $request->input('ingredient');

        // $area = "Canadian";
        // $category = "";
        // $ingredient = "Onions";


        $areaResponse = $area ? Http::get('www.themealdb.com/api/json/v1/1/filter.php?a=' . $area) : null;
        $categoryResponse = $category ? Http::get('www.themealdb.com/api/json/v1/1/filter.php?c=' . $category) : null;
        $ingredientResponse = $ingredient ? Http::get('www.themealdb.com/api/json/v1/1/filter.php?i=' . $ingredient) : null;

        $responsesSuccessful = true;
        $areaMeals = $categoryMeals = $ingredientMeals = [];

        if ($areaResponse && $areaResponse->successful()) {
            $areaMeals = array_column($areaResponse->json()['meals'], 'idMeal');
        } elseif ($areaResponse) {
            $responsesSuccessful = false;
        }

        if ($categoryResponse && $categoryResponse->successful()) {
            $categoryMeals = array_column($categoryResponse->json()['meals'], 'idMeal');
        } elseif ($categoryResponse) {
            $responsesSuccessful = false;
        }

        if ($ingredientResponse && $ingredientResponse->successful()) {
            $ingredientMeals = array_column($ingredientResponse->json()['meals'], 'idMeal');
        } elseif ($ingredientResponse) {
            $responsesSuccessful = false;
        }

        if (!$responsesSuccessful) {
            return $this->returnError('Something Rong');
        }

        $mealIds = [];

        if ($area && $category && $ingredient) {
            $mealIds = array_intersect($areaMeals, $categoryMeals, $ingredientMeals);
        } elseif ($area && $category) {
            $mealIds = array_intersect($areaMeals, $categoryMeals);
        } elseif ($area && $ingredient) {
            $mealIds = array_intersect($areaMeals, $ingredientMeals);
        } elseif ($category && $ingredient) {
            $mealIds = array_intersect($categoryMeals, $ingredientMeals);
        } elseif ($area) {
            $mealIds = $areaMeals;
        } elseif ($category) {
            $mealIds = $categoryMeals;
        } elseif ($ingredient) {
            $mealIds = $ingredientMeals;
        }

        $mealDetailsArray = collect();

        foreach (array_slice($mealIds, 0, 6) as $mealId) {
            $mealDetails = $this->fetchMealDetails($mealId);

            if ($mealDetails) {
                $this->PushData($mealDetailsArray, $mealDetails);
            } else {
                return $this->returnError('Something Rong');
            }
        }

        return $this->returnData('', 'meals', $mealDetailsArray);
    }

    public function searchMealsByName(Request $request)
    {
        $name = $request->input('name');
        if ($name === null || $name === '') {
            return  $this->returnData('', 'meals', []);
        }

        $response = Http::get('https://www.themealdb.com/api/json/v1/1/search.php?s=' . $name);

        if ($response->successful()) {
            $meals = $response->json()['meals'];

            if ($meals === null) {
                return  $this->returnData('', 'meals', []);
            }

            $meals = array_slice($meals, 0, 4);


            $mealDetailsArray = $this->returnData('', 'meals', $this->fetchMealDetailsArray($meals));

            return $mealDetailsArray;
        } else {
            return $this->returnError('Something Rong');
        }
    }


    public function fetchRandomMeals()
    {
        $mealDetailsArray = collect();
        $fetchedMealIds = [];

        for ($i = 0; $i < 10; $i++) {
            $response = Http::get('www.themealdb.com/api/json/v1/1/random.php');

            if ($response->successful()) {
                $mealDetails = $response->json()['meals'][0];
                $mealId = $mealDetails['idMeal'];

                if (!in_array($mealId, $fetchedMealIds)) {
                    $this->PushData($mealDetailsArray, $mealDetails);
                    $fetchedMealIds[] = $mealId;
                }
            } else {
                return $this->returnError('Something Rong');
            }
        }

        return $this->returnData('', 'meals', $mealDetailsArray);
    }

    private function fetchMealDetailsArray($meals)
    {
        $mealDetailsArray = collect();

        foreach ($meals as $mealDetails) {
            $this->PushData($mealDetailsArray, $mealDetails);
        }

        return $mealDetailsArray;
    }

    private function fetchMeals($param, $value)
    {
        $response = Http::get("www.themealdb.com/api/json/v1/1/filter.php?$param=$value");

        if ($response->successful()) {
            $meals = $response->json()['meals'];
            $meals = array_slice($meals, 0, 6);

            $mealDetailsArray = collect();

            foreach ($meals as $meal) {
                $mealDetails = $this->fetchMealDetails($meal['idMeal']);

                if ($mealDetails) {
                    $this->PushData($mealDetailsArray, $mealDetails);
                } else {
                    return $this->returnError('Something Rong');
                }
            }

            return $mealDetailsArray;
        } else {
            return $this->returnError('Something Rong');
        }
    }

    private function fetchMealDetails($mealId)
    {
        $response = Http::get("www.themealdb.com/api/json/v1/1/lookup.php?i=$mealId");

        if ($response->successful()) {
            $mealDetails = $response->json('meals.0');
            if ($mealDetails !== null) {
                return [
                    'idMeal' => $mealDetails['idMeal'],
                    'strMeal' => $mealDetails['strMeal'],
                    'strCategory' => $mealDetails['strCategory'],
                    'strArea' => $mealDetails['strArea'],
                    'strMealThumb' => $mealDetails['strMealThumb'],
                    'strIngredient1' => $mealDetails['strIngredient1'],
                    'strIngredient2' => $mealDetails['strIngredient2'],
                    'strIngredient3' => $mealDetails['strIngredient3'],
                    'strIngredient4' => $mealDetails['strIngredient3'],
                    'strIngredient5' => $mealDetails['strIngredient3'],
                    'strMeasure1' => $mealDetails['strMeasure1'],
                    'strMeasure2' => $mealDetails['strMeasure2'],
                    'strMeasure3' => $mealDetails['strMeasure3'],
                    'strMeasure4' => $mealDetails['strMeasure4'],
                    'strMeasure5' => $mealDetails['strMeasure5'],
                    'description' => $mealDetails['strInstructions'],

                ];
            } else {
                return null;
            }
        } else {
            return $this->returnError('Something Rong');
        }
    }
}
