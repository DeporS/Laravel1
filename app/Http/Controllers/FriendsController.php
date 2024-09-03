<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use Auth;

class FriendsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $friends = Friend::where('user_id', Auth::user()->id)
        ->orderBy('status', 'desc')
        ->get(); 
        
        // // Możesz mapować je, aby uzyskać potrzebne dane, jeśli chcesz
        $friendsData = $friends->map(function($friend) {
            $user = User::find($friend->friend_id);
            return [
                'id' => $friend->friend_id,
                'path' => $user ? $user->profile_picture_path : null,
                'name' => $user ? $user->name : null,
                'status' => $friend->status,
                'sender_id' => $friend->sender_id,
                'relation_id' => $friend->id,
            ];
        });

        return view('friends.friendsIndex', compact('friendsData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('friends.friendsForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        $friendName = $request->name;

        $friendId = User::where('name', $friendName)->value('id');

        if($friendId == Auth::user()->id){
            return redirect()->back()->withErrors(['name' => 'Nie możesz wysłać zaproszenia do siebie.']);
        }

        // sprawdzenie czy relacja juz istnieje
        $existingRequest = Auth::user()->sentFriendRequests()->where('friend_id', $friendId)->where('status', 'pending')->exists();
        
        if($existingRequest) {
            return redirect()->back()->withErrors(['name' => 'Już wysłano zaproszenie do tego użytkownika.']);
        }  

        // sprawdzenie czy nie jest sie juz znajomym
        $existingFriend = Auth::user()->sentFriendRequests()->where('friend_id', $friendId)->where('status', 'accepted')->exists();
        
        if($existingFriend) {
            return redirect()->back()->withErrors(['name' => 'Ten użytkownik już jest twoim znajomym.']);
        }  
        
        if($friendId){
            // podwojne bo w dwie strony
            Auth::user()->sentFriendRequests()->create([
                'user_id' => Auth::user()->id,
                'friend_id' => $friendId,
                'status' => 'pending',
            ]);

            Auth::user()->sentFriendRequests()->create([
                'user_id' => $friendId,
                'friend_id' => Auth::user()->id,
                'status' => 'pending',
            ]);

            return redirect()->back()->with('status', 'Zaproszenie wysłane.');
        }

        return redirect()->back()->withErrors(['name' => 'Nie znaleziono użytkownika o podanej nazwie.']);
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id); // pobiera zdjecie o danym id
        return view('friends.friendsShow', ['user' => $user]);
    }

    /**
     * Akceptacja zaproszenia
     */
    public function accept(string $id)
    {
        $friend = Friend::FindOrFail($id);

        $friendRequest = Friend::where('user_id', $friend->friend_id)
                       ->where('friend_id', Auth::id())
                       ->where('status', 'pending')
                       ->first();

        if ($friendRequest) {
            $friendRequest->update(['status' => 'accepted']);
        }

        $friendRequest2 = Friend::where('user_id', Auth::id())
                       ->where('friend_id', $friend->friend_id)
                       ->where('status', 'pending')
                       ->first();

        if ($friendRequest2) {
            $friendRequest2->update(['status' => 'accepted']);
        }

        return redirect()->back()->with('status', 'Zaproszenie zaakceptowane.');
    }

    public function delete(string $id)
    {
        $friend = Friend::FindOrFail($id);

        $friendRequest = Friend::where('user_id', $friend->friend_id)
                           ->where('friend_id', Auth::id())
                           ->first();

        if ($friendRequest) {
            $friendRequest->delete();
        }

        $friendRequest2 = Friend::where('user_id', Auth::id())
                                ->where('friend_id', $friend->friend_id)
                                ->first();

        if ($friendRequest2) {
            $friendRequest2->delete();
        }

        return redirect()->back()->with('status', 'Friend deleted.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }

    
}
