<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use App\Models\Product;


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
     * Show the form for buying an item.
     */

    public function buy()
    {
        return view('shop.shopBuy');
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
}
