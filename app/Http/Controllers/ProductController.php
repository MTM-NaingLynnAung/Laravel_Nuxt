<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        if(request('search')){
            return Product::where('name', 'LIKE', '%' . request('search') . '%')->orderBy('id', 'desc')->paginate(5);
        }
        return Product::orderBy('id', 'desc')->paginate(5);
    }
    public function show(Product $product)
    {
        return $product;
    }
    public function store(ProductRequest $request)
    {
        $fileName = time().'.'.$request->image->extension();
        Storage::putFileAs('public/images', $request->image, $fileName);
        $request->image = 'images/'.$fileName;
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
            $filePath = "storage/".$product->image;
            if(file_exists($filePath)){
                unlink($filePath);
            }
            $fileName = time().'.'.$request->image->extension();
            Storage::putFileAs('public/images', $request->image, $fileName);
            $requestData['image'] = 'images/'.$fileName;
        }
        return $product->update($requestData);

    }
    public function destroy(Product $product)
    {
        $filePath = "storage/".$product->image;
        if(file_exists($filePath)){
            unlink($filePath);
        }
        return $product->delete();
    }
}
