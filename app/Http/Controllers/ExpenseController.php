<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function createExpense(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string|max:255',
            'vendor' => 'required|string|max:255',
            'currency' => 'required|string|max:3', // assuming a 3-letter currency code like USD, EUR
            'Description' => 'nullable|string',
            'Recipet_Attach' => 'required|boolean',
        ]);

        try {
            // Create a new expense
            $expense = Expense::create([
                'category' => $request->input('category'),
                'amount' => $request->input('amount'),
                'payment_method' => $request->input('payment_method'),
                'vendor' => $request->input('vendor'),
                'currency' => $request->input('currency'),
                'Description' => $request->input('Description'),
                'Recipet_Attach' => $request->input('Recipet_Attach'),
            ]);

            // Return success response
            return response()->json([
                'message' => 'Expense created successfully',
                'expense' => $expense
            ], 201);

        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'message' => 'An error occurred while creating the expense',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function editExpense($id)
{
    try {
        // Find the expense by ID
        $expense = Expense::findOrFail($id);

        // Return success response with the expense data
        return response()->json([
            'message' => 'Expense retrieved successfully',
            'expense' => $expense
        ], 200);

    } catch (\Exception $e) {
        // Return error response if expense not found or other error occurs
        return response()->json([
            'message' => 'Expense not found',
            'error' => $e->getMessage()
        ], 404);
    }
}


public function updateExpense(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'category' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'payment_method' => 'required|string|max:255',
        'vendor' => 'required|string|max:255',
        'currency' => 'required|string|max:3',
        'Description' => 'nullable|string',
        'Recipet_Attach' => 'required|boolean',
    ]);

    try {
        // Find the expense by ID
        $expense = Expense::findOrFail($id);

        // Update the expense with the new data
        $expense->update([
            'category' => $request->input('category'),
            'amount' => $request->input('amount'),
            'payment_method' => $request->input('payment_method'),
            'vendor' => $request->input('vendor'),
            'currency' => $request->input('currency'),
            'Description' => $request->input('Description'),
            'Recipet_Attach' => $request->input('Recipet_Attach'),
        ]);

        // Return success response
        return response()->json([
            'message' => 'Expense updated successfully',
            'expense' => $expense
        ], 200);

    } catch (\Exception $e) {
        // Return error response
        return response()->json([
            'message' => 'An error occurred while updating the expense',
            'error' => $e->getMessage()
        ], 500);
    }
}


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

    public function deleteExpense($id)
{
    try {
        // Find the expense by ID
        $expense = Expense::findOrFail($id);

        // Delete the expense
        $expense->delete();

        // Return success response
        return response()->json([
            'message' => 'Expense deleted successfully'
        ], 200);

    } catch (\Exception $e) {
        // Return error response if something goes wrong or expense is not found
        return response()->json([
            'message' => 'An error occurred while deleting the expense',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
