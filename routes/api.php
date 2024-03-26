<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MealController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    // test
    return "Welcome in Qwiri API";
});

Route::group(['middleware' => ['api', 'CheckPassword'], 'namespace' => 'api'], function () {

    Route::post('categories', [CategoryController::class, 'fetchCategories']);
    Route::post('ingredients', [IngredientController::class, 'fetchIngredients']);
    Route::post('areas', [AreaController::class, 'fetchAreas']);

    Route::post('mealsByArea', [MealController::class, 'fetchMealsByArea']);
    Route::post('mealsByCategory', [MealController::class, 'fetchMealsByCategory']);
    Route::post('mealsByIngredient', [MealController::class, 'fetchMealsByIngredient']);
    Route::post('mealsByName', [MealController::class, 'searchMealsByName']);
    Route::post('mealsByAreaAndCategoryAndIngredient', [MealController::class, 'fetchMealsByAreaAndCategoryAndIngredient']);
    Route::post('mealById', [MealController::class, 'fetchMealById']);
    Route::post('randomMeals', [MealController::class, 'fetchRandomMeals']);
});
