<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\MessageSent;
use App\Events\GreatingChat;
use App\Events\NotificationChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        # code...
    }

    public function show()
    {
        return view('Chat.showAll');
    }

    public function store(Request $request)
    {
        Log::info(json_encode($request->user()->name));
        $rules = [
            'message'   => 'required'
        ];

        $request->validate($rules);

        broadcast(new MessageSent($request->user(), $request->message));

        return response()->json('message broadcast');
    }

    public function greet(Request $request, User $id)
    {
        broadcast(new GreatingChat($request->user(), "Kamu mencoba menyapa {$id->name}"));
        broadcast(new GreatingChat($id, "{$request->user()->name} menyapa anda"));
        return response()->json('message success');
    }

    public function notification(Request $request, User $id)
    {
        broadcast(new NotificationChat($id, $id->name . " menyapa kamu"));
        return 'ok';
    }
}
