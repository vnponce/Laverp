<?php

namespace App\Http\Controllers;

use App\Product;
use App\Store;
use Illuminate\Http\Request;

class ProductStoreController extends Controller
{
    public function index(Store $store)
    {
        return view('stores.show-products', compact('store'));
    }

    public function add(Store $store)
    {
        $products = Product::all();
        return view('stores.add-product', compact('products', 'store'));
    }

    public function store(Store $store)
    {
        $store->products()->attach(request()->get('product_id'),[
            'quantity' => request()->get('quantity'),
            'price' => request()->get('price'),
        ]);

    }
}
