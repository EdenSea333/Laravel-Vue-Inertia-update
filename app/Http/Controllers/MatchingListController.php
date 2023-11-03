<?php

namespace App\Http\Controllers;
use App\Http\Requests\MatchingListStoreRequest;
use App\Models\MatchingList;

use Illuminate\Http\Request;

class MatchingListController extends Controller
{
    public function index(Request $request)
    {
        ray(asldkflsadkfj);
        // $term = $request->input('term');
        // ray("ok1");
        // $products = Product::with('capacityUnit', 'category')
        //     ->when($term, function ($query, $term) {
        //         $query->where('brand', 'LIKE', '%' . $term . '%')
        //             ->orWhere('model', 'LIKE', '%' . $term . '%')
        //             ->orwhere('color', 'LIKE', '%' . $term . '%');
        //     })
        //     ->paginate(50);
        // return Inertia::render('Products/Index', compact('products'));
    }

    public function update(Request $request, string $id, string $supply_product)
    {
        // Product::where('id', $id)->update($request->all());
        ray($id, $supply_product);
        // return redirect('/products')->with('success', 'Product has been updated!');
    }
}
