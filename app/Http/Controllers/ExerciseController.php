<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Validator;
use Exception;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $exercise = Exercise::orderBy('name')->get();

            return response()->json([
                'data' => $exercise,
            ], 200);
        }
        catch(Exception $e) {
            return response()->json([
                'message' => '500_message',
                'error' => (object)[
                    $e->getCode() => [$e->getMessage()],
                ],
            ]);
        }
    }
}
