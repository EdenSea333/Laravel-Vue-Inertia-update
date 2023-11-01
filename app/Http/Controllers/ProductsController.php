<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use App\Models\CapacityUnit;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $term = $request->input('term');
        ray("ok1");
        $products = Product::with('capacityUnit', 'category')
            ->when($term, function ($query, $term) {
                $query->where('brand', 'LIKE', '%' . $term . '%')
                    ->orWhere('model', 'LIKE', '%' . $term . '%')
                    ->where('color', 'LIKE', '%' . $term . '%');
            })
            ->paginate(50);
        // return $products;
        return Inertia::render('Products/Index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $capacityUnits = CapacityUnit::all();
        $categories = Category::all();
        return Inertia::render('Products/Create', compact('capacityUnits', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $validatedData = $request->validated();
        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Product has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $getProduct = Product::findOrFail($id);

        return Inertia::render('Products/Show', compact('getProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $capacityUnits = CapacityUnit::all();
        $categories = Category::all();
        $product = Product::findOrFail($id);
        ray($categories);
        return Inertia::render('Products/Edit', compact('product', 'capacityUnits', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Product::where('id', $id)->update($request->all());

        return redirect('/products')->with('success', 'Product has been updated!');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    public function destroy(string $id)
    {
        Product::destroy($id);

        return back()->with('delete', 'Product has been deleted!');
    }

    public function deleteMultiple(Request $request)
    {
        $productIds = $request->input('ids');
        Product::whereIn('id', $productIds)->delete();

        return redirect()->route('products.index')->with('success', 'Operation successfully!');
    }
}