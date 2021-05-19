<?php

namespace App\Http\Controllers;

use App\Models\Calorie;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

class CalorieController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $calories = Calorie::select('*')
                ->where('user_id', Auth::id())
                ->orderBy('id', 'DESC')
                ->get();
            $workouts = Workout::select('*')
                ->where('user_id', Auth::id())
                ->get();

            foreach($workouts as $workout) {
                $w_date[] = $workout->workout_date;
            }
            
            foreach($calories as $calorie) {
                $c_date = $calorie->date;
                if(in_array($c_date, $w_date)) {
                    $calorie['worked_out'] = 'Yes';
                } else {
                    $calorie['worked_out'] = 'No';
                }
            }
            
            if(sizeof($calories) > 0) {
                return response()->json([
                    "message" => count($calories) . ' calories logged for user.',
                    "data" => $calories,
                ], 200);
            }
            else {
                return response()->json([
                    "message" => 'No calories posted.'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => '500_message',
                'error' => (object)[
                    $e->getCode() => [$e->getMessage()],
                ],
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'required|date|date_format:Y-m-d',
                'calories_consumed' => 'required'
            ]);
    
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            
            $calories = Calorie::create([
                'user_id' => Auth::id(),
                'date' => $request->date,
                'calories_consumed' => $request->calories_consumed,
            ]);
    
            return response()->json([
                'message' => 'Calories posted successfully.',
                'data' => $calories,
            ], 201); 

        } catch (Exception $e) {
            return response()->json([
                'message' => '500_message',
                'errors' => (object)[
                    $e->getCode() => [$e->getMessage()],
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calorie  $calorie
     * @return \Illuminate\Http\Response
     */
    public function show(Calorie $calorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calorie  $calorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Calorie $calorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calorie  $calorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calorie $calorie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calorie  $calorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calorie $calorie)
    {
        //
    }
}
