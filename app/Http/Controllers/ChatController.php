<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PusherBroadcast;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat/chatIndex');
    }

    public function broadcast(Request $request)
    {
        broadcast(new PusherBroadcast($request->get('message')))->toOthers();

        return view('chat/chatBroadcast', ['message' => $request->get('message')]);
    }

    public function receive()
    {
        return view('chat/chatReceive', ['message' => $request->get('message')]);
    }
}
