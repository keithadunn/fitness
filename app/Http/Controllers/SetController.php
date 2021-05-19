<?php

namespace App\Http\Controllers;

use App\Models\Set;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

class SetController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'workout_date' => 'required|date|date_format:Y-m-d',
                'workout_length' => 'required',
            ]);
    
            if($validator->fails()){
                return response()->json(['message' => $validator->errors()->toJson()], 400);
            }
            
            $workout = Workout::create([
                'user_id' => Auth::id(),
                'workout_type' => "Strength Training",
                'workout_date' => $request->workout_date,
                'workout_length' => $request->workout_length,
            ]);
    
            $workout_id = $workout->id;
            
            $set = array();

            foreach($request->set_info as $key) {
                foreach($key['sets'] as $k) {
                    $set[] = [
                        'exercise_id' => $key['exercise_id'],
                        'workout_id' => $workout_id,
                        'reps' => $k['reps'],
                        'weight_lifted' => $k['weight_lifted']
                    ];
                }
            }

            Set::insert($set);

            return response()->json([
                'message' => 'successful',
                'data' => $workout,
            ], 201);  

        } catch (Exception $e) {
            return response()->json([
                'message' => (object)[
                    $e->getCode() => [$e->getMessage()],
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $workout = Workout::select('*')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $set = Set::with('exercises')->where('workout_id', $workout->id)->get();

            return response()->json([
                "message" => $workout,
                "set_data" => $set,
                "workout_data" => $workout
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => (object)[
                    $e->getCode() => [$e->getMessage()],
                ],
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            /*
            not working
             
            $workout = Workout::select('id')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->first();

            $sets_ids = [];
            foreach($workout->sets as $key => $value) {
                $sets_ids[] = intval($value->id);  
            }

            $update_sets = Set::whereIn('id', $sets_ids)->update($request->all()); */


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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function destroy(Set $set)
    {
        
    }
}
