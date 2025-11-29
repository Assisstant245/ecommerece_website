<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),

            new Middleware('permission:view products', only: ['index']),
            new Middleware('permission:create products', only: ['create', 'store']),
            new Middleware('permission:edit products', only: ['edit', 'update']),
            new Middleware('permission:delete products', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'subcategory'])->get();
        return view('admin.products.view', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();
        return view('admin.products.add', compact('category'));
    }

    

    public function getSubcategories($category_id)
    {
        $subcategories = SubCategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string|max:255',
            'product_image' => 'required|array',
            'product_image.*' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'product_whole_price' => 'required|numeric',
            'product_sale_price' => 'required|numeric',
            'product_sku' => 'required|string|max:50|unique:products,sku',
            'product_status' => 'required|in:online,offline',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',




        ]);
        $newImage = [];
        if ($request->hasFile('product_image')) {
            foreach ($request->file('product_image') as $img) {
                $originalImage = $img->getClientOriginalExtension();
                $uniqueName = time() . "_" . uniqid() . "." . $originalImage;
                $img->move('products', $uniqueName);
                $newImage[] = $uniqueName;
            }
        }

        $existingProduct = Product::where('product_name', $request->product_name)->first();

        if ($existingProduct) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Product already exists',
            ]);
        }

        Product::create([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'product_image' => json_encode($newImage),
            'product_whole_price' => $request->product_whole_price,
            'product_price' => $request->product_sale_price,
            'sku' => $request->product_sku,
            'product_status' => $request->product_status,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
        ]);
        return response()->json([
            'message' => 'product added successfully',
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
        $product = Product::findorFail($id);
        $category = Category::all();
        $subcategories = SubCategory::all();

        return view('admin.products.edit', compact('product', 'category', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string|max:255',
            'product_image' => 'array',
            'product_image.*' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'product_whole_price' => 'required|numeric',
            'product_sale_price' => 'required|numeric',
            'product_sku' => 'required|string|max:50|unique:products,sku,' . $id,
            'product_status' => 'required|in:online,offline',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
        ]);
        $existingProduct = Product::where('product_name', $request->product_name)->where('id', '!=', $id)->first();

        if ($existingProduct) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Product already exists',
            ]);
        }

        $product = Product::findOrFail($id);
        $existingImages = json_decode($product->product_image, true) ?? [];
        $newImages = [];

        if ($request->hasFile('product_image')) {
            foreach ($existingImages as $oldImg) {
                $oldPath = public_path('products/' . $oldImg);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            foreach ($request->file('product_image') as $image) {
                $originalName = $image->getClientOriginalName();
                $uniqueName = time() . '_' . uniqid() . '_' . $originalName;
                $image->move(public_path('products'), $uniqueName);
                $newImages[] = $uniqueName;
            }
        } else {
            $newImages = $existingImages;
        }

        $product->update([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'product_image' => json_encode($newImages),
            'product_whole_price' => $request->product_whole_price,
            'product_price' => $request->product_sale_price,
            'sku' => $request->product_sku,
            'product_status' => $request->product_status,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
        ]);

        return response()->json(['message' => 'Product updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $product = Product::findorFail($id);
        $oldImagePath = public_path('products/' . $product->product_image);
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully.']);
    }
}
