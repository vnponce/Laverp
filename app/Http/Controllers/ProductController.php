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
        return view('products.show', compact('product'));
    }
    public function create()
    {
        return view('products.create');
    }

    public function store()
    {
        $this->validate(request(),[
            'title' => 'required',
            'description' => 'required',
            'photo' => 'required',
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
        $product = Product::create(request()->all());
        return redirect('products');
    }
}
