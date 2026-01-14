<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Product::latest()->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'image_path'       => 'required|image|mimes:jpeg,jpg,png|max:2048',
        'name'       => 'required|string|min:5',
        'description' => 'required|string|min:10',
        'price'       => 'required|numeric',
        'stock'       => 'required|integer|min:0'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    if (!$request->hasFile('image_path')) {
        return response()->json([
            'message' => 'Image file not found'
        ], 422);
    }

    $imagePath = $request->file('image_path')->store('products', 'public');

    $product = Product::create([
        'image_path'       => $imagePath,
        'name'       => $request->name,
        'description' => $request->description,
        'price'       => $request->price,
        'stock'       => $request->stock
    ]);

    return response()->json([
        'message' => 'Product created successfully',
        'data'    => $product
    ], 201);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'image_path'       => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'name'       => 'required|string|min:5',
            'description' => 'required|string|min:10',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Update image if exists
        if ($request->hasFile('image_path')) {
            Storage::disk('public')->delete($product->image_path);

            $product->image_path = $request
                ->file('image_path')
                ->store('products', 'public');
        }

        $product->update([
            'name'       => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock
        ]);

        return response()->json([
            'message' => 'Product updated successfully',
            'data'    => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        Storage::disk('public')->delete($product->image_path);
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
