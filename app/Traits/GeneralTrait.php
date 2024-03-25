<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait GeneralTrait
{
    public function returnError($msg)
    {
        return response()->json([
            'status' => false,
            'msg' => $msg,
        ]);
    }

    public function returnData($msg, $key, $data)
    {
        return response()->json(['status' => true, 'msg' => $msg, $key => $data,]);
    }

    public function returnSucces($msg)
    {
        return response()->json([
            'status' => true,
            'msg' => $msg,
        ]);
    }


    public function PushData($mealDetailsArray, $mealDetails)
    {
        $mealDetailsArray->push([
            'id' => $mealDetails['idMeal'],
            'name' => $mealDetails['strMeal'],
            'category' => $mealDetails['strCategory'],
            'area' => $mealDetails['strArea'],
            'image' => $mealDetails['strMealThumb'],
            'ingredient1' => $mealDetails['strIngredient1'],
            'ingredient2' => $mealDetails['strIngredient2'],
            'ingredient3' => $mealDetails['strIngredient3'],
            'measure1' => $mealDetails['strMeasure1'],
            'measure2' => $mealDetails['strMeasure2'],
            'measure3' => $mealDetails['strMeasure3'],
        ]);
    }
}
