<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
}
