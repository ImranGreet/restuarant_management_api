<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function retrieveExpenses()
    {
        try {
            $orders = Expense::paginate(10);

            if ($orders->isEmpty()) {
                return response()->json([
                    'message' => 'No expenses found',
                    'orders' => []
                ], 404);
            }
            return response()->json([
                'message' => 'Expenses retrieved successfully',
                'orders' => $orders
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function retrieveExpensesByDateRange(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $orders = Expense::whereBetween('created_at', [$startDate, $endDate])->paginate(10);

            if ($orders->isEmpty()) {
                return response()->json([
                    'message' => 'No expenses found for the selected date range',
                    'orders' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Expenses retrieved successfully',
                'orders' => $orders
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
