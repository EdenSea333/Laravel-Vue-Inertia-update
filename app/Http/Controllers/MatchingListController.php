<?php

namespace App\Http\Controllers;
use App\Http\Requests\MatchingListStoreRequest;
use App\Models\MatchingList;
use App\Models\Product;
use App\Modles\CapacityUnit;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

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

    public function saveMacthingInformation(Request $req) {
        $productName = $req->input('productName');
        $selectedProduct = $req->input('selectedProduct');
        $matchinglist = new MatchingList();
        $matchinglist -> product_id = $selectedProduct;
        $matchinglist -> name = $productName;
        $matchinglist -> save();
        // dd($productName, $selectedProduct);
        return redirect()->back()->with('success', 'Product has been added!');
    }

    public function showSelectPage(Request $req, string $product) {
        $productName = urldecode($product);
        //dd($productName);
        // ray(urldecode($product));
        $products=Product::with('capacityUnit', 'category')->paginate(10);
        
        return Inertia::render('Files/Select', compact('productName', 'products'));

    }
}
