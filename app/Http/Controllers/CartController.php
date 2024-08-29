<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\DiscountCode;

class CartController extends Controller
{
    // dodanie produktu do koszyka
    public function add(Request $request, $id)
    {
        // zapomnienie o znizce
        session()->forget('discounted_sum');
        session()->forget('code_id');

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

            // usuniecie znizki
            session()->forget('discounted_sum');
            session()->forget('code_id');
        }

        return redirect()->back()->with('success', 'Product deleted from cart!');
    }

    // naliczenie znizki
    public function applyDiscount(Request $request){
        $cart = session()->get('cart', []);
        $price_sum = 0;

        foreach ($cart as $cart_el) {
            $price_sum += $cart_el['price'] * $cart_el['quantity'];
        }

        // pobierz kod znizkowy
        $discountCode = DiscountCode::where('code', $request->input('discount_code'))
            ->where('status', 'active')
            // ->where('start_date', '<=', now())
            // ->where('expiration_date', '>=', now())
            ->first();

        if (!$discountCode) {
            return redirect()->back()->withErrors(['discount_code' => 'Invalid or expired discount code.']);
        }

        if ($price_sum < $discountCode->min_cart_value) {
            return redirect()->back()->withErrors(['discount_code' => 'Minimum cart value not met for this discount code.']);
        }

        // oblicz nowa sume
        $discounted_sum = $price_sum * $discountCode->price_multiply;

        // Zapisz nową sumę w sesji lub przekaż do widoku
        session()->put('discounted_sum', $discounted_sum);
        session()->put('code_id', $discountCode->id);

        return view('cart.cartShow', compact('cart', 'price_sum', 'discounted_sum'));
    }
}
