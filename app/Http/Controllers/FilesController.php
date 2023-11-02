<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Files;
use App\Imports\StockList;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $term = $request->input('term');
        $files = Files::with('user')
            ->paginate(50);
        ray($files);
        // return $products;
        return Inertia::render('Files/Index', compact('files'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
                        "id" => $row['no'],
                        "product" => $product['brand'] . ' ' . $product['model'] . ' ' . $product['color']
                    ];
                    $rows[$ix]['mapped'] = $product['brand'] . ' ' . $product['model'] . ' ' . $product['color'];
                    break;
                }
            }
        }
        return Inertia::render('Files/Show', compact('rows', 'file'));
    }
    
    public function destroy(string $id)
    {
        // Product::destroy($id);

        // return back()->with('delete', 'Product has been deleted!');
    }

    public function deleteMultiple(Request $request)
    {
        // $productIds = $request->input('ids');
        // Product::whereIn('id', $productIds)->delete();

        // return redirect()->route('products.index')->with('success', 'Operation successfully!');
    }

    public function getFilesByUserID($id) {
        return Files::where('user_id', $id)->paginate(50);
    }

    public function getFilesByUser(Request $request) {
        $id = $request->input('id');
        $files = $this->getFilesByUserID($id);
        return Inertia::render('Files/List', compact('files'));
    }

    public function getMyFiles(Request $request) {
        $user = $request->user();
        $files = $this->getFilesByUserID($user->id);
        return Inertia::render('Files/List', compact('files'));
    }

    public function uploadFile(Request $request) {
        $data = new Files();
        $data->user_id = $request->user()->id;
        $data->status = 'unread';
        if ($request->hasFile('file')) {
            $avatarPath = $request->file('file')->store('public/excel_files');
            $data->file_name = $avatarPath;
        }
        $data->save();
        return redirect()->route('files.mine')->with('success', 'File uploaded!');
    }
}