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
}
