<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        return Product::orderBy('id', 'desc')->paginate(5);
    }
    public function show(Product $product)
    {
        return $product;
    }
    public function store(ProductRequest $request)
    {
        $fileName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $fileName);
        $request->image = '/images/'.$fileName;
        return Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $request->image
        ]);
    }
    public function update(ProductRequest $request)
    {
        $product = Product::find($request->id);
        $requestData = $request->all();
        if($request->hasFile('image')){
            $filePath = public_path($product->image);
            if(file_exists($filePath)){
                unlink($filePath);
            }
            $fileName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $fileName);
            $requestData['image'] = '/images/'.$fileName;
        }
        return $product->update($requestData);

    }
    public function destroy(Product $product)
    {
        $filePath = public_path($product->image);
        if(file_exists($filePath)){
            unlink($filePath);
        }
        return $product->delete();
    }
}
