<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Files;
use App\Models\Stock;
use App\Models\MatchingList;
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
        $stocksList = Stock::with('product')
            ->when($term, function ($query, $term) {
                $query->where('name', 'LIKE', '%' . $term . '%')
                    ->orWhere('email', 'LIKE', '%' . $term . '%');
            })
            ->paginate(20);
        return Inertia::render('Stocks/Index', compact('stocksList'));
    }

    
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
        $stock_list = [];
        foreach($rows as $ix => $row){
            $stock = [];
            $data = MatchingList::where('name', 'like', '%'.$row['product'].'%')->first();
            if($data != null){
                // dd($data['product_id']);
                $product_id=$data['product_id'];
                $stock = [
                    'product_id' => $product_id,
                    'quantity' => $row['qty']
                ];
            }
            else
                foreach($products as $product){
                    if (strstr($row['product'], $product['brand']) && strstr($row['product'], $product['model']) && strstr($row['product'], $product['color']) ) {// && strstr( $row['product'], $product['capacity']) && strstr($row['product'], $product['capacity_unit'])
                        $stock = [
                            'product_id' => $product['id'],
                            'quantity' => $row['qty']
                        ];
                        break;
                    }
                }
            array_push($stock_list, $stock);
        }
        foreach($stock_list as $stock){
            if($stock != null){
                $data_stock=Stock::where('product_id', "=", $stock['product_id'] )->first();
                if($data_stock == null){
                    $final_stock_list = new Stock();
                    $final_stock_list -> product_id = $stock['product_id'];
                    $final_stock_list -> quantity = intval($stock['quantity']);
                    $final_stock_list -> save();
                }
                else{
                    $data_stock->quantity += intval($stock['quantity']);
                    $data_stock->save();
                }
            }
            
        }

        $result_stock_list=Stock::all();
        // return redirect('/stocks', compact($result_stock_list))->with('success', 'File has been matched!');
        // return Inertia::render()->with('success', 'File has been matched!');

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
