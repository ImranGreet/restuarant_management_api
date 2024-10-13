<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Function to retrieve all categories with pagination
    public function retrieveCategories()
    {
        try {
            $categories = Category::paginate(10);

            if ($categories->isEmpty()) {
                return response()->json([
                    'message' => 'No categories found',
                    'categories' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Categories retrieved successfully',
                'categories' => $categories
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to retrieve a single category by ID
    public function retrieveCategoryById($id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found',
                ], 404);
            }

            return response()->json([
                'message' => 'Category retrieved successfully',
                'category' => $category
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to create a new category
    public function createCategory(Request $request)
    {
        // Validate the request data
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        try {
            // Create a new category record
            $category = Category::create($request->all());

            return response()->json([
                'message' => 'Category created successfully',
                'category' => $category
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to edit a category (retrieve by ID)
    public function editCategory($id)
    {
        try {
            // Retrieve the category by its ID
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found'
                ], 404);
            }

            return response()->json([
                'message' => 'Category retrieved successfully',
                'category' => $category
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to update a category
    public function updateCategory(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'category' => 'sometimes|required|string|max:255',
        ]);

        try {
            // Find the category by its ID
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found'
                ], 404);
            }

            // Update the category with the provided data
            $category->update($request->all());

            return response()->json([
                'message' => 'Category updated successfully',
                'category' => $category
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Function to delete a category
    public function deleteCategory($id)
    {
        try {
            // Find the category by its ID
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found'
                ], 404);
            }

            // Delete the category
            $category->delete();

            return response()->json([
                'message' => 'Category deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
