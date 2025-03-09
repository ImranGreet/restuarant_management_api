<?php

namespace App\Http\Controllers;

use App\Models\Stuff;
use Illuminate\Http\Request;

class StuffController extends Controller
{
    // Function to retrieve all stuff items with pagination
    public function retrieveStuffs(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 20);
            $allowedPerPage = [10, 20, 30, 40, 50];

            if (!in_array($perPage, $allowedPerPage)) {
                return response()->json([
                    'message' => 'Invalid per_page value. Allowed values are 10, 20, 30, 40, 50.',
                ], 400);
            }
            $stuffs = Stuff::paginate($perPage);

            if ($stuffs->isEmpty()) {
                return response()->json([
                    'message' => 'No stuffs found',
                    'stuffs' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Stuffs retrieved successfully',
                'stuffs' => $stuffs
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving stuffs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to create a new stuff item
    public function createStuff(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_from' => 'required|date',
            'contact_normal' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'salary_wages' => 'required|integer',
            'benifits' => 'required|string',
            'vacation_peroid' => 'required|integer',
            'training_records' => 'required|string|max:255',
            'contact_emergency' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        try {
            // Create a new stuff record
            $stuff = Stuff::create($request->all());

            return response()->json([
                'message' => 'Stuff created successfully',
                'stuff' => $stuff
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating stuff',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to edit a stuff item (retrieve by ID)
    public function editStuff($id)
    {
        try {
            // Retrieve the stuff item by its ID
            $stuff = Stuff::find($id);

            if (!$stuff) {
                return response()->json([
                    'message' => 'Stuff not found'
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

    // Function to update a stuff item
    public function updateStuff(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'position' => 'sometimes|required|string|max:255',
            'start_from' => 'sometimes|required|date',
            'contact_normal' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:255',
            'salary_wages' => 'sometimes|required|integer',
            'benifits' => 'sometimes|required|string',
            'vacation_peroid' => 'sometimes|required|integer',
            'training_records' => 'sometimes|required|string|max:255',
            'contact_emergency' => 'sometimes|required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        try {
            // Find the stuff item by its ID
            $stuff = Stuff::find($id);

            if (!$stuff) {
                return response()->json([
                    'message' => 'Stuff not found'
                ], 404);
            }

            // Update the stuff item with the provided data
            $stuff->update($request->all());

            return response()->json([
                'message' => 'Stuff updated successfully',
                'stuff' => $stuff
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating stuff',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to delete a stuff item
    public function deleteStuff($id)
    {
        try {
            // Find the stuff item by its ID
            $stuff = Stuff::find($id);

            if (!$stuff) {
                return response()->json([
                    'message' => 'Stuff not found'
                ], 404);
            }

            // Delete the stuff item
            $stuff->delete();

            return response()->json([
                'message' => 'Stuff deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting stuff',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to delete multiple stuff items
public function deleteMultipleStuffs(Request $request)
{
    try {
        // Validate the request to ensure 'ids' is provided and is an array
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:stuffs,id'
        ]);

        // Retrieve the IDs from the request
        $ids = $request->input('ids');

        // Delete the specified stuff items
        Stuff::whereIn('id', $ids)->delete();

        return response()->json([
            'message' => 'Selected stuffs deleted successfully'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred while deleting stuffs',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
