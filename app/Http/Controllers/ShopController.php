<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use App\Models\Product;
use App\Models\Order;
use App\Models\DiscountCode;
use App\Mail\OrderPlaced;
use DB;
use Illuminate\Support\Facades\Mail;


class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        // zmapowanie wszystkich danych z bazy
        $productsData = $products->map(function($product){
            return[
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'paths' => json_decode($product->paths, true)
            ];
        });

        // otwarcie view i przekazanie danych do niego
        return view('shop/shopIndex', compact('productsData'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shop.shopForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $paths = [];

        // $request->validate([
        //     'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        //     'price' => 'required|numeric|gt:0',
        // ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('listings', 'public');
                array_unshift($paths, $path); // dodawanie na poczatek tablicy
            }
        }

        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->paths = json_encode($paths); // Zapisz jako JSON
        
        // sprawdzenie czy zostala podana szczegolna ilosc przedmiotu
        if($request->filled('available')){
            $product->available = $request->input('available');
        }
        
        $product->save();

        return redirect()->route('shop.index')->with('success', 'Listing added successfully.');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('shop.shopShow', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('shop.shopEdit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        // aktualizacja pol produktu
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        // zapis nowych zdjec
        if ($request->hasFile('photos')) {
            $paths = json_decode($product->paths, true); // pobranie istniejacych sciezek

            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('listings', 'public');
                $paths[] = $path; // dodanie nowych sciezek
            }

            $product->paths = json_encode($paths); // zapisanie wszystkich sciezek
        }

        $product->save();

        return redirect()->route('shop.show', $product->id)->with('success', 'Product updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if($product->paths){
            $paths = json_decode($product->paths, true);
            foreach ($paths as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $product->delete();

        return redirect()->route('shop.index')->with('success', 'Listing deleted successfully.');
    }


    /**
     * Show the form for buying an item.
     */
    public function buy()
    {
        // Sprawdzenie czy quantity nie jest zbyt wysokie
        $cart = session()->get('cart', []);

        foreach ($cart as $cartItem){
            $product = Product::find($cartItem['id']);

            if ($product->available < $cartItem['quantity']){
                $message = "The quantity for <strong>{$product->name}</strong> exceeds available stock.";
                return redirect()->route('cart.show')->withErrors([
                    'quantity_error' => $message
                ]);
            }
        }
        
        return view('shop.shopBuy');
    }


    /**
     * Validate order form and send data to database.
     */
    public function validateOrder(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|alpha|max:255',
            'customer_surname' => 'required|alpha|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|numeric',
            'address_line_1' => 'required|max:255',
            'address_line_2' => 'nullable|max:255',
            'city' => 'required|alpha|max:255',
            'state' => 'nullable|alpha|max:255',
            'postal_code' => 'required|postal_code:PL,DE',
            'country' => 'required|alpha|max:255'
        ]);

        Mail::to($request->customer_email)->send(new OrderPlaced([
            'name' => $request->customer_name,
        ]));

        // wypelniane przez uzytkownika
        $order = new Order;
        $order->customer_name = $request->customer_name;
        $order->customer_surname = $request->customer_surname;
        $order->customer_email = $request->customer_email;
        if($request->filled('customer_phone')){
            $order->customer_phone = $request->customer_phone;
        }
        $order->address_line_1 = $request->address_line_1;
        if($request->filled('address_line_2')){
            $order->address_line_2 = $request->address_line_2;
        }
        $order->city = $request->city;
        if($request->filled('state')){
            $order->state = $request->state;
        }
        $order->postal_code = $request->postal_code;
        $order->country = $request->country;

        // wypelniane z automatu

        // pobranie koszyka
        $cart = session()->get('cart', []);

        $price_sum = 0;
        $order_cart = [];

        foreach ($cart as $cart_el) {
            $item = [
                'id' => $cart_el['id'],
                'name' => $cart_el['name'],
                'quantity' => $cart_el['quantity']
            ];
        
            $order_cart[] = $item; 

            $price_sum += $cart_el['price'] * $cart_el['quantity'];
        }

        // ze znizka
        if (session('discounted_sum')){
            $order->price = session('discounted_sum');
            DB::table('discount_codes')->where('id', session('code_id'))->decrement('usage_limit');
        }else{
            // bez znizki
            $order->price = $price_sum;
        }
        
        
        $order->items = json_encode($order_cart);

        $order->save();

        // wyzerowanie koszyka
        session()->forget('cart');

        return view('shop.shopPayment');
    }

}
