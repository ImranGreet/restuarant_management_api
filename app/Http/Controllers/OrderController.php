<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function createOrder(Request $request)
    {
        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'order_no' => 'required|string|unique:orders',
                'order_items' => 'required|json',
                'order_type' => 'required|string',
                'payment_method' => 'required|string',
                'status' => 'required|string',
                'time_placed' => 'required|date',
            ]);

            // Create a new order using the validated data
            $order = Order::create([
                'order_no' => $validatedData['order_no'],
                'order_items' => $validatedData['order_items'],
                'order_type' => $validatedData['order_type'],
                'payment_method' => $validatedData['payment_method'],
                'status' => $validatedData['status'],
                'time_placed' => $validatedData['time_placed'],
            ]);

            // Return a successful response
            return response()->json([
                'message' => 'Order created successfully',
                'order' => $order
            ], 201); // Created

        } catch (\Exception $e) {
            // Handle any exceptions during order creation
            return response()->json([
                'message' => 'An error occurred while creating the order',
                'error' => $e->getMessage()
            ], 500); // Internal Server Error
        }
    }

    public function updateOrder(Request $request, $id)
{
    try {
        // Validate the incoming request
        $validatedData = $request->validate([
            'order_no' => 'required|string|unique:orders,order_no,' . $id, // Ensures uniqueness except for the current order
            'order_items' => 'required|array',  // Ensure the order_items is an array
            'order_type' => 'required|string',
            'payment_method' => 'required|string',
            'status' => 'required|string',
            'time_placed' => 'required|date',
        ]);

        // Find the order by ID, throw an exception if not found
        $order = Order::findOrFail($id);

        // Encode the order_items array to JSON string before saving
        $validatedData['order_items'] = json_encode($validatedData['order_items']);

        // Update the order with the validated data
        $order->update($validatedData);

        // Return a successful response
        return response()->json([
            'message' => 'Order updated successfully',
            'order' => $order
        ], 200); // OK

    } catch (\Exception $e) {
        // Handle any exceptions during order update
        return response()->json([
            'message' => 'An error occurred while updating the order',
            'error' => $e->getMessage()
        ], 500); // Internal Server Error
    }
}

    public function retrieveOrder()
    {
        try {

            $orders = Order::paginate(25);

            if ($orders->isEmpty()) {
                return response()->json([
                    'message' => 'No orders found',
                    'orders' => []
                ], 404);
            }
            return response()->json([
                'message' => 'Orders retrieved successfully',
                'orders' => $orders
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'An error occurred while retrieving orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function retrieveOrderByType($type)
    {
        try {
            // Validate the $type parameter
            if (!in_array($type, ['pending', 'delivery', 'canceled', 'pickup'])) {
                return response()->json([
                    'message' => 'Invalid order type provided',
                    'orders' => []
                ], 400); // Bad Request
            }



            $orders = Order::where('order_type', $type)->paginate(25);


            if ($orders->isEmpty()) {
                return response()->json([
                    'message' => "No orders found for the type: $type",
                    'orders' => []
                ], 404); // Not Found
            }


            return response()->json([
                'message' => 'Orders retrieved successfully',
                'orders' => $orders
            ], 200); // OK

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'An error occurred while retrieving orders',
                'error' => $e->getMessage()
            ], 500); // Internal Server Error
        }
    }

    public function deleteOrder($id)
    {
        try {

            $order = Order::find($id);
            if (!$order) {
                return response()->json([
                    'message' => "Order with ID $id not found",
                ], 404); // Not Found
            }
            $order->delete();

            return response()->json([
                'message' => 'Order deleted successfully',
            ], 200); // OK

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'An error occurred while deleting the order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
