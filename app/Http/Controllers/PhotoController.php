<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = Storage::files('public/photos'); // pobiera wszystkie zdjecia
        $photos = array_map(function($photo) {
            return basename($photo); // zwraca nazwe pliku
        }, $photos);

        return view('photos.photoIndex', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('photos.photoForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            
            // zapisuje sciezke do pliku w bazie danych
            Photo::create([
                'path' => $path,
            ]);
        }
    
        return redirect()->route('photos.index')->with('success', 'Photo added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $photo = Photo::findOrFail($id); // pobiera zdjecie o danym id
        return view('photos.photoShow', ['photo' => $photo]); // przekazuje zdjecie do widoku
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $photo = Photo::findOrFail($id);

        // zwroc formularz do edycji
        return view('photos.photoEdit', compact('photo'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photo = Photo::findOrFail($id);

        if ($request->hasFile('photo')) {
            // usuwa stare zdjecie
            if ($photo->path) {
                Storage::disk('public')->delete($photo->path);
            }

            // zapisuje nowe zdjecie
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            
            $photo->path = $path;
        }

        $photo->save();

        return redirect()->route('photos.index')->with('success', 'Photo updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);

        // usuwa zdjecie z dysku
        if ($photo->path) {
            Storage::disk('public')->delete($photo->path);
        }

        // usuwa rekord z bazy danych
        $photo->delete();

        return redirect()->route('photos.index')->with('success', 'Photo deleted successfully.');
    }

}
