<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        if(!auth()->user()->isAdmin()){
            return redirect('/products');
        }
        return view('products.show', compact('product'));
    }
    public function create()
    {
        if(!auth()->user()->isAdmin()){
            return redirect('/products');
        }
        return view('products.create');
    }

    public function store()
    {
        if(!auth()->user()->isAdmin()){
            return redirect('/products');
        }
        $this->validate(request(),[
            'title' => 'required',
            'description' => 'required',
            'image' => ['nullable', 'image'],
            'code' => 'required',
            'sku' => 'required',
            'volume' => 'required',
            'weight' => 'required',
            'price' => 'required',
            'cost' => 'required',
            'condition' => 'required',  // Terminado, matería prima, o ambas
            'days_to_deliver' => 'required',
//            'category_id' => 'required',  // habrá categorias
            'unit_of_measure' => 'required',  // pieza, metros, cosas de esas
        ]);
        $algo = request()->hasFile('image') ? request('image')->store('products', 'local') : null;

        $product = Product::create(request()->all());
        $product->image = $algo;
        $product->save();

        return redirect('products');
    }

    public function edit(Product $product)
    {
        if(!auth()->user()->isAdmin()){
            return redirect('/products');
        }
        return view('products.edit', compact('product'));
    }

    public function update(Product $product)
    {
        if(!auth()->user()->isAdmin()){
            return redirect('/products');
        }
        $product->update(request()->all());
        return redirect('products');
    }

    public function destroy(Product $product)
    {
        if(!auth()->user()->isAdmin()){
            return redirect('/products');
        }
        $product->delete();
        return redirect('products');
    }
}
