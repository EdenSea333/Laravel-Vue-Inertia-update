<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Files;
use App\Models\Stock;
use App\Imports\StockList;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class StocksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $term = $request->input('term');

        $users = User::with('role')
            ->when($term, function ($query, $term) {
                $query->where('name', 'LIKE', '%' . $term . '%')
                    ->orWhere('email', 'LIKE', '%' . $term . '%');
            })
            ->latest()
            ->paginate(5);

        return Inertia::render('Stocks/Index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return Inertia::render('Users/Create');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(UserStoreRequest $request)
    // {
    //     $validatedData = $request->validated();

    //     if ($request->hasFile('avatar')) {
    //         $avatarPath = $request->file('avatar')->store('public/avatars');
    //         $validatedData['avatar'] = Storage::url($avatarPath);
    //     }

    //     $validatedData['password'] = Hash::make($validatedData['password']);
    //     User::create($validatedData);

    //     return redirect()->route('users.index')->with('success', 'User has been created!');
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     $getUser = User::findOrFail($id);

    //     return Inertia::render('Users/Show', compact('getUser'));
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     $user = User::findOrFail($id);

    //     return Inertia::render('Users/Edit', compact('user'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
     public function update(Request $request, string $id)
    {
        $file = Files::findOrFail($id);
        $filePath = storage_path('app/public/excel_files/'.$file->file_name);
        $rows = Excel::toArray(new StockList(), $filePath)[0];
        $header = [
            "#", "Product", "Grade", "Vat Type", "Qty", "Offer", "Total"
        ];
        $offset = array_search(Arr::first($rows, function($row) {
            return $row[0] == "#" &&
                $row[1] == "Product" &&
                $row[2] == "Grade" &&
                $row[3] == "Vat Type" &&
                $row[4] == "Qty" &&
                $row[5] == "Offer" &&
                $row[6] == "Total";
        }), $rows);
        $rows = array_map(fn($row) => [
                "no" => $row[0],
                "product" => $row[1],
                "grade" => $row[2],
                "vat_type" => $row[3],
                "qty" => $row[4],
                "offer" => $row[5],
                "mapped" => ''
            ], array_filter(array_slice($rows, $offset + 1), function($row) {
                return $row[1] != null;
            }));

        $products = Product::all()->toArray();
        $mapping_list = [];
        foreach($rows as $ix => $row){
            foreach($products as $product){
                if (strstr($row['product'], $product['brand']) && strstr($row['product'], $product['model']) && strstr($row['product'], $product['color']) ) {// && strstr( $row['product'], $product['capacity']) && strstr($row['product'], $product['capacity_unit'])
                    $mapping_list[] =  [
                        "id" => $product['id'],
                        "quantity" => $row['qty']
                    ];
                    $rows[$ix]['mapped'] = $product['brand'] . ' ' . $product['model'] . ' ' . $product['color'];
                    break;
                }
            }
        }
        foreach($mapping_list as $data) {
            
        }
        return redirect('/stocks')->with('success', 'File has been matched!');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     User::destroy($id);

    //     return back()->with('delete', 'User has been deleted!');
    // }

    // public function deleteMultiple(Request $request)
    // {
    //     $userIds = $request->input('ids');
    //     User::whereIn('id', $userIds)->delete();

    //     return redirect()->route('users.index')->with('success', 'Operation successfully!');
    // }
}
