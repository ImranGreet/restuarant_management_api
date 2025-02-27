<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Function to retrieve all products with pagination
    public function retrieveProducts()
    {
        try {
            $products = Product::paginate(10);

            if ($products->isEmpty()) {
                return response()->json([
                    'message' => 'No products found',
                    'products' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Products retrieved successfully',
                'products' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //function to retrieve all products according to the category with pagination
    public function retrieveProductsByCategory($category)
    {
        try {
            $products = Product::where('category', $category)->paginate(10);

            if ($products->isEmpty()) {
                return response()->json([
                    'message' => 'No products found',
                    'products' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Products retrieved successfully',
                'products' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving products',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // Function to retrieve a single product by ID
    public function retrieveProductById($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product not found',
                ], 404);
            }

            return response()->json([
                'message' => 'Product retrieved successfully',
                'product' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to create a new product
    public function createProduct(Request $request)
    {
        // Validate the request data
        $request->validate([
            'product_title' => 'required|string|max:255',
            'product_image' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|integer',
            'status' => 'required|boolean',
            'description' => 'required|string',
            'rating' => 'nullable|numeric',
            'discount' => 'nullable|integer',
        ]);

        try {
            // Create a new product record
            $product = Product::create($request->all());

            return response()->json([
                'message' => 'Product created successfully',
                'product' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to edit a product (retrieve by ID)
    public function editProduct($id)
    {
        try {
            // Retrieve the product by its ID
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product not found'
                ], 404);
            }

            return response()->json([
                'message' => 'Product retrieved successfully',
                'product' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to update a product
    public function updateProduct(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'product_title' => 'sometimes|required|string|max:255',
            'product_image' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|integer',
            'status' => 'sometimes|required|boolean',
            'description' => 'sometimes|required|string',
            'rating' => 'nullable|numeric',
            'discount' => 'nullable|integer',
        ]);

        try {
            // Find the product by its ID
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product not found'
                ], 404);
            }

            // Update only the fields provided in the request
            $product->fill($request->only([
                'product_title',
                'product_image',
                'category',
                'price',
                'status',
                'description',
                'rating',
                'discount'
            ]));

            // Save the updated product
            $product->save();

            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    //function to update status of a product
    public function updateProductStatus(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'status' => 'required|boolean',
        ]);

        try {
            // Find the product by its ID
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product not found'
                ], 404);
            }

            // Update only the status field
            $product->status = $request->status;
            $product->save();

            return response()->json([
                'message' => 'Product status updated successfully',
                'product' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the product status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // Function to delete a product
    public function deleteProduct($id)
    {
        try {
            // Find the product by its ID
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product not found'
                ], 404);
            }

            // Delete the product
            $product->delete();

            return response()->json([
                'message' => 'Product deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
