<?php

namespace App\Http\Controllers;

use App\Events\NoticeEvent;
use App\Events\SendMessageEvent;
use Illuminate\Http\Request;

class WebsocketController extends Controller
{
    public function visit() {
        event(new NoticeEvent());
    }

    public function chat(Request $request){
        $userName = $request->input('user_name');
        $receiverName = $request->input('receiver_name');
        if((empty($userName)  && empty($receiverName)) || ($userName==$receiverName)){
            return view('home');
        }
        return view('chat',compact('userName','receiverName'));
    }

    public function sendMessage(Request $request, $userName, $receiverName){
        event(new SendMessageEvent($userName,$receiverName,$request->input('message')));
        return response("",200);
    }
}
