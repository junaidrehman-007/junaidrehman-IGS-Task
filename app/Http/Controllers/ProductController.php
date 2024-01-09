<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Products::get();
        // return response()->json(['message' => 'Welcome to the Product API', 'products' => $product], 201);
        return response()->json([
            'message' => 'All products retrieved successfully',
            'data' => ProductResource::collection($product),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|between:0.01,999999.99',
            'quantity' => 'required|integer|min:1|max:99',
        ]);
        try {
            $product = Products::create([
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ]);
        
            return new ProductResource($product, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
           
            return response()->json(['error' => $e->errors()], 400);
        } catch (\Exception $e) {
          
            return response()->json(['error' => 'Failed to create the product.'], 500);
        }}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Products::where('id', $id)->first();
        if ($product) {
            return response()->json(['message' => 'Product', 'data' => ProductResource::collection($product)], 201);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Products::findOrFail($id);
        $product->update($request->all());

        if ($product) {
            return response()->json(['message' => 'Product updated successfully', 'data' => ProductResource::collection($product)], 201);
        } else {
            return response()->json(['error' => 'Product id Not Found'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Products::where('id', $id)->delete();
        if ($product) {
            return response()->json(['message' => 'Product Deleted successfully'], 201);
        } else {
            return response()->json(['error' => 'Product id Not Found'], 500);
        }
    }

    public function sorted()
    {

        $products = Products::orderBy('price', 'asc')->get();

        return response()->json([
            'message' => 'All products sorted by price in ascending order',
            'data' => ProductResource::collection($products),
        ]);
    }
}
