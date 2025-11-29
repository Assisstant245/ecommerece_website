<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),

            new Middleware('permission:view category', only: ['index']),
            new Middleware('permission:create category', only: ['create', 'store']),
            new Middleware('permission:edit category', only: ['edit', 'update']),
            new Middleware('permission:delete category', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.view', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'required|string|max:255',

        ]);

        // Check if category already exists

        $existingCategory = Category::where('category_name', $request->category_name)->first();

        if ($existingCategory) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Category already exists',
            ]); 
        }
        
        Category::create([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description,
        ]);
        return response()->json([
            'message' => 'category added successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findorFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_name' => 'required|max:255|string',
            'category_description' => 'required|max:255|string'
        ]);
        // Check if category already exists


        $existingCategory = Category::where('category_name', $request->category_name)->where('id', '!=', $id)->first();

        if ($existingCategory) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Category already exists',
            ]);
        }
        $category = Category::findorFail($id);

        $category->update([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description,

        ]);
        return response()->json([
            'message' => 'Category updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findorFail($id);
        $category->delete();
        return response()->json(['message' => 'category deleted successfully.']);
    }
}
