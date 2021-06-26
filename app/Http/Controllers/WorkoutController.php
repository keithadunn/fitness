<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class WorkoutController extends Controller
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
            $workouts = Workout::select('*')
                ->where('user_id', Auth::id())
                ->orderBy('id', 'DESC')
                ->with('sets.exercises')
                ->get();

            if(sizeof($workouts) > 0) {
                return response()->json([
                    "status" => "Successful",
                    "workout_count" => count($workouts),
                    "data" => $workouts,
                ], 200);
            }
            else {
                return response()->json([
                    "message" => 'No workouts posted.'
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
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $workout = Workout::select('id', 'user_id')
                ->where('user_id', '=', Auth::id())
                ->where('id', '=', $id)
                ->exists();
        
            return response()->json([
                "message" => "Successful",
                "data" => $workout,
            ], 200);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $workout = Workout::where('user_id', Auth::id())->firstOrFail();
            $workout->workout_date = $request->workout_date;
            $workout->workout_length = $request->workout_length;
            $workout->update();

            return response()->json([
                "message" => "Successful",
                "data" => $workout,
            ], 200);

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
     * @param  \App\Models\Workout  $workout
     * @return int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $workout_exists = Workout::select('id', 'user_id')
                ->where('user_id', '=', Auth::id())
                ->where('id', '=', $id)
                ->exists();

            $workout = DB::table('workouts')
                ->where('id', '=', $id)
                ->where('user_id', '=', Auth::id())
                ->delete();

            return response()->json([
                "message" => "Successful",
                "data" => $workout
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => '500_message',
                'errors' => (object)[
                    $e->getCode() => [$e->getMessage()],
                ],
            ]);
        }
    }
}
