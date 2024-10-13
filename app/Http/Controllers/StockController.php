<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // Function to retrieve all stock items with pagination
    public function retrieveStocks()
    {
        try {
            $stocks = Stock::paginate(10);

            if ($stocks->isEmpty()) {
                return response()->json([
                    'message' => 'No stocks found',
                    'stocks' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Stocks retrieved successfully',
                'stocks' => $stocks
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving stocks',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to retrieve stock items between two dates
    public function retrieveStocksByDateRange(Request $request)
    {
        // Validate the start_date and end_date
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        try {
            // Get start and end dates from the request
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Query stock items between the given dates
            $stocks = Stock::whereBetween('created_at', [$startDate, $endDate])->paginate(10);

            if ($stocks->isEmpty()) {
                return response()->json([
                    'message' => 'No stocks found for the selected date range',
                    'stocks' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Stocks retrieved successfully',
                'stocks' => $stocks
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving stocks',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to create a new stock item
    public function createStock(Request $request)
    {
        // Validate the request data
        $request->validate([
            'product_title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'reorder_point' => 'required|string|max:255',
            'quantity_in_hand' => 'required|integer',
            'minimum_quantity_in_hand' => 'required|integer',
            'leadtime' => 'required|integer',
            'preferred_supplier' => 'required|string|max:255',
            'ingredient_use' => 'required|integer|in:0,1',
            'expiration_date' => 'required|date',
            'location' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        try {
            // Create a new stock record
            $stock = Stock::create($request->all());

            return response()->json([
                'message' => 'Stock created successfully',
                'stock' => $stock
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to edit a stock item (retrieve it by ID)
    public function editStock($id)
    {
        try {
            // Retrieve the stock by its ID
            $stock = Stock::find($id);

            if (!$stock) {
                return response()->json([
                    'message' => 'Stock not found'
                ], 404);
            }

            return response()->json([
                'message' => 'Stock retrieved successfully',
                'stock' => $stock
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to update a stock item
    public function updateStock(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'product_title' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|max:255',
            'reorder_point' => 'sometimes|required|string|max:255',
            'quantity_in_hand' => 'sometimes|required|integer',
            'minimum_quantity_in_hand' => 'sometimes|required|integer',
            'leadtime' => 'sometimes|required|integer',
            'preferred_supplier' => 'sometimes|required|string|max:255',
            'ingredient_use' => 'sometimes|required|integer|in:0,1',
            'expiration_date' => 'sometimes|required|date',
            'location' => 'sometimes|required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        try {
            // Find the stock item by its ID
            $stock = Stock::find($id);

            if (!$stock) {
                return response()->json([
                    'message' => 'Stock not found'
                ], 404);
            }

            // Update the stock item with the provided data
            $stock->update($request->all());

            return response()->json([
                'message' => 'Stock updated successfully',
                'stock' => $stock
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to delete a stock item
    public function deleteStock($id)
    {
        try {
            // Find the stock item by its ID
            $stock = Stock::find($id);

            if (!$stock) {
                return response()->json([
                    'message' => 'Stock not found'
                ], 404);
            }

            // Delete the stock item
            $stock->delete();

            return response()->json([
                'message' => 'Stock deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
