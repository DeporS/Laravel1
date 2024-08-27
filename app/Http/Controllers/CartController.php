<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // dodanie produktu do koszyka
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $path;

        if ($product->paths) {
            $paths = json_decode($product->paths, true);
         
            if (is_array($paths) && isset($paths[0])) {
                $path = $paths[0];
            }
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $id,
                'img' => $path,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // wyswietlenie koszyka i policzenie ceny
    public function show()
    {
        $cart = session()->get('cart', []);

        $price_sum = 0;

        foreach ($cart as $cart_el) {
            $price_sum += $cart_el['price'] * $cart_el['quantity'];
        }

        return view('cart.cartShow', compact('cart', 'price_sum'));
    }

    // usuniecie przedmiotu z koszyka
    public function delete($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if($cart[$id]['quantity'] > 1){
                $cart[$id]['quantity'] -= 1;
            }else{
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product deleted from cart!');
    }
}
