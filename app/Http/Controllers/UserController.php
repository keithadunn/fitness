<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Weight;
use App\Models\Workout;
use Validator;

class UserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function update(Request $request) {
        try {

            $user = Auth::user();
            if(!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    "message" => "Incorrect current password"
                ]);
                
            } else {
                $user->password = Hash::make($request->new_password);
                $user->email = $request->email;
                $user->save();

                return response()->json([
                    "message" => "Successfully updated"
                ], 200);
            }

        } catch (Exception $e) {

        }
    }

    /**
     * Get the authenticated Users statistics.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function userStats() {

        try {
            $workouts = Workout::select('*')
                ->where('user_id', Auth::id())
                ->orderBy('id', 'DESC')
                ->get();
            
            $latest_weight_logged = Weight::select('weight', 'date')
                ->where('user_id', Auth::id())
                ->latest('created_at')
                ->first();
            $first_weight_logged = Weight::select('weight')
                ->where('user_id', Auth::id())
                ->first();
            
            $weight = Weight::select('weight', 'date')
                ->where('user_id', Auth::id())
                ->orderBy('id', 'DESC')
                ->get();
            

            if(sizeof($workouts) > 0) {
                return response()->json([
                    "workout_count" => count($workouts),
                    "last_workout" => $workouts->pluck('workout_date')->first(),
                    "last_weight_logged" => $latest_weight_logged,
                    "weights" => $weight
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

    public function userCharts() {

        $selectWeightDates = Weight::select('weight', 'date')
            ->where('user_id', Auth::id())
            ->orderBy('date', 'asc')
            ->get();

        $dates = [];
        $weights = [];
        foreach($selectWeightDates as $i) {
            $dates[] = $i->date;
            $weights[] = $i->weight;
        }
    
    
        return response()->json([
            "dates" => $dates,
            "weights" => $weights
        ]);
    }
}
