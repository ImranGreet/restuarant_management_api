<?php

namespace App\Http\Controllers;

use App\Models\Stuff;
use Illuminate\Http\Request;

class StuffController extends Controller
{
    // Function to retrieve all stuff items with pagination
    public function retrieveStuff()
    {
        try {
            $stuff = Stuff::paginate(20);

            if ($stuff->isEmpty()) {
                return response()->json([
                    'message' => 'No stuff found',
                    'stuff' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Stuff retrieved successfully',
                'stuff' => $stuff
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving stuff',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
