<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

use App\Events\ProductCreated;
use App\Events\ProductUpdated;
use App\Events\ProductEvent;

use ZipArchive;

class ProductController extends Controller
{
    public function index() {
        try 
        {
            $products = Product::all();
        }
        catch (\Exception $e) 
        {
            // Handle the error, log it, or display a custom error message.
            return view('products.error', ['message' => 'Error fetching products']);
        }
    
        // Check if products were fetched successfully
        if ($products->isEmpty()) {
            // Products are not available, display an error message or handle it as needed.
            return view('products.error', ['message' => 'No products found']);
        }
    
        return view('products.index', ['products' => $products]);

    }

    public function create() {
        return view('products.create');
    }
    
    public function store(Request $request) {
        //dd is used for dumping the products
        // dd($request->name);
    
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|decimal:0,2',
            'description' => 'nullable'
        ]);
        
        // $product = 
        

        // $temp = ['name'=>$data['name'], 'qty' => $data['qty'], 'message' => 'Product created successfully'];

        // $product->fireModelEvent('created');
        // event(new ProductEvent($product));
        // event(new ProductCreated($temp));
        
        return redirect()->route('product.index');
    }
    
    public function edit(Product $product) {
        // dd($product);
        return view('products.edit', ['product' => $product]);
    }

    public function update(Product $product, Request $request) {
        
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|decimal:0,2',
            'description' => 'nullable'
        ]);

        $product->update($data);

        // $temp = ['name'=>$data['name'], 'qty' => $data['qty'], 'message' => 'Product updated successfully'];

        // event(new ProductEvent($temp));
        // event(new ProductUpdated($temp));

        return redirect()->route('product.index')->with('success', 'Product updated Succesffully');
    }

    public function delete(Product $product)
    {
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted Succesffully');
    }

    public function ag_grid_products() {
        $products = Product::all();

        return view('ag_grid', ['products' => $products]);
    }

    public function zip_download() {
        try {
            $products = Product::all();

            $zip = new ZipArchive();
            $zipFileName = 'data.zip';

            if ($zip->open($zipFileName, ZipArchive::CREATE) === true) 
            {
                $zip->addFromString('products.json', json_encode($products));
                $zip->close();
            
                return response()->download($zipFileName, 'data.zip', ['Content-Type' => 'application/zip'])
                    ->deleteFileAfterSend(true);
            } else {
                return view('products.error', ['message' => 'Error creating zip file']);
            }
            
        } catch (\Exception $e) {
            return view('products.error', ['message' => 'Error fetching response' . $e]);
        }

        return view('products.error', ['message' => 'API request failed']);
    }


}
