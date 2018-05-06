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
        $product = Product::find(request('product_id'));
        if($product->available_quantity < request('quantity')){
            return back()
                ->withInput()
                ->withErrors([
                    'quantity' => 'La cantidad disponible no es la suficiente.'
                ]);
        }
        $quantity = request()->get('quantity');
        if ($store->products->contains($product->id)) {
            $existing_quantity = $store->products->find($product->id)->pivot->quantity;
            $quantity += $existing_quantity;
            $store->products()->updateExistingPivot(request()->get('product_id'),[
                'quantity' => $quantity,
//                'price' => request()->get('price'),
            ]);
        } else {
            $store->products()->attach(request()->get('product_id'),[
                'quantity' => $quantity,
                'price' => request()->get('price'),
            ]);
        }
    }

    public function reduce(Store $store, Product $product)
    {
        $existing_quantity = $store->products->find($product->id)->pivot->quantity;
        $quantity = $existing_quantity - request()->get('quantity');
        $store->products()->updateExistingPivot($product->id,[
            'quantity' => $quantity,
//            'price' => request()->get('price'),
        ]);
    }
}
