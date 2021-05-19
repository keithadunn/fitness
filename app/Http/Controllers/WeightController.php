<?php

namespace App\Http\Controllers;

use App\Models\Weight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

class WeightController extends Controller
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
            $weight = Weight::select('*')
                ->where('user_id', Auth::id())
                ->orderBy('id', 'DESC')
                ->get();
            
            if(sizeof($weight) > 0) {
                return response()->json([
                    "message" => count($weight) . ' weights logged for user.',
                    "data" => $weight,
                ], 200);
            }
            else {
                return response()->json([
                    "message" => 'No weights logged.'
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
                'weight' => 'required|numeric'
            ]);
    
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            
            $weight = Weight::create([
                'user_id' => Auth::id(),
                'date' => $request->date,
                'weight' => $request->weight,
            ]);
    
            return response()->json([
                'message' => 'Weight posted successfully.',
                'data' => $weight,
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
}
