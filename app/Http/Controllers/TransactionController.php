<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Function to retrieve all transactions with pagination
    public function retrieveTransactions()
    {
        try {
            $transactions = Transaction::paginate(10);

            if ($transactions->isEmpty()) {
                return response()->json([
                    'message' => 'No transactions found',
                    'transactions' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Transactions retrieved successfully',
                'transactions' => $transactions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving transactions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to retrieve transactions between two dates
    public function retrieveTransactionsByDateRange(Request $request)
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

            // Query transactions between the given dates
            $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])->paginate(10);

            if ($transactions->isEmpty()) {
                return response()->json([
                    'message' => 'No transactions found for the selected date range',
                    'transactions' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Transactions retrieved successfully',
                'transactions' => $transactions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving transactions',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
