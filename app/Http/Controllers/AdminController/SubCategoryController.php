<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SubCategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('permission:view subcategory', only: ['index']),
            new Middleware('permission:create subcategory', only: ['create', 'store']),
            new Middleware('permission:edit subcategory', only: ['edit', 'update']),
            new Middleware('permission:delete subcategory', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategory = SubCategory::with('category')->get();

        return view('admin.sub_category.view', compact('subcategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();

        return view('admin.sub_category.add', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)

    {

        $request->validate([
            'sub_category_name' => 'required|string|max:255',
            'sub_category_description' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',


        ]);

        $existingSubcategory = SubCategory::where('sub_category_name', $request->sub_category_name)->first();

        if ($existingSubcategory) {
            return response()->json([
                'status' => 'exists',
                'message' => 'SubCategory already exists',
            ]);
        }
        SubCategory::create([
            'sub_category_name' => $request->sub_category_name,
            'sub_category_description' => $request->sub_category_description,
            'category_id' => $request->category_id,


        ]);
        return response()->json([
            'message' => 'sub category added successfully',
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
        $subcategory = SubCategory::findorFail($id);
        $category = Category::all();

        return view('admin.sub_category.edit', compact('subcategory', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'sub_category_name' => 'required|max:255|string',
            'sub_category_description' => 'required|max:255|string',
            'category_id' => 'required|exists:categories,id',

        ]);
        $existingSubcategory = SubCategory::where('sub_category_name', $request->sub_category_name)->where('id', '!=', $id)->first();

        if ($existingSubcategory) {
            return response()->json([
                'status' => 'exists',
                'message' => 'SubCategory already exists',
            ]);
        }
        $subcategory = SubCategory::findorFail($id);

        $subcategory->update([
            'sub_category_name' => $request->sub_category_name,
            'sub_category_description' => $request->sub_category_description,
            'category_id' => $request->category_id,


        ]);
        return response()->json([
            'message' => 'sub Category updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subcategory = SubCategory::findorFail($id);
        $subcategory->delete();
        return response()->json(['message' => 'subcategory deleted successfully.']);
    }
}
