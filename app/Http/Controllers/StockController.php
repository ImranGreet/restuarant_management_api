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
}
