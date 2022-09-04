<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewAdminChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function chat(){
        $chats = DB::table('chat_sessions')->select()->get();
        $files = Storage::files("chat");
        foreach($chats as $chat){
            if(!in_array($chat->address,$files)){
                $item =DB::table('chat_sessions')->where('id',$chat->id)->delete();
            }
        }
        $chats = DB::table('chat_sessions')->select()->get();
        if(auth()->check() && auth()->user()->user_type == 1){
            $admin= auth()->user();

        }

        return view('chat',compact('chats','admin'));
    }



    public function post(Request $request){
        $text = $_POST['text'];

        if(auth()->check() && auth()->user()->user_type == 1){
            $name=$_POST['name'] ?? null;
            if($name != null){
                $chat = DB::table('chat_sessions')->where('name',$name)->first();
                $contents = "<div class='direct-chat-msg right'><div class='direct-chat-info clearfix'><span class='direct-chat-name pull-right'>admin--</span><span class='direct-chat-timestamp pull-left'>".date('Y-m-d g:i A')."</span></div> <img class='direct-chat-img' src='https://img.icons8.com/office/36/000000/person-female.png'alt='message user image'> <div class='direct-chat-text'>".stripslashes(htmlspecialchars($text))."</div>";
            }else{
                $chatmax = DB::table('chat_sessions')->max('updated_at');
                $chat= DB::table('chat_sessions')->where('updated_at',$chatmax)->first();
                if($chat != null){
                    $contents="<div class='direct-chat-msg right'><div class='direct-chat-info clearfix'><span class='direct-chat-name pull-right'>admin--</span><span class='direct-chat-timestamp pull-left'>".date('Y-m-d g:i A')."</span></div> <img class='direct-chat-img' src='https://img.icons8.com/office/36/000000/person-female.png'alt='message user image'> <div class='direct-chat-text'>".stripslashes(htmlspecialchars($text))."</div>";

                }else{
                    return response()->json(['status' => true]);
                }

            }
            Storage::append($chat->address, $contents);
            DB::table('chat_sessions')->where('name',$name)->update(['updated_at'=>now()]);



    }else{
        $admins= User::where('user_type',1)->get();
        $name = session('name');
        $chat = DB::table('chat_sessions')->where('name',$name)->first();
            $contents = "<div class='direct-chat-msg'><div class='direct-chat-info clearfix'><span class='direct-chat-name pull-left'>".session('name').'--'. "</span><span class='direct-chat-timestamp pull-right'>".date('Y-m-d g:i A')."</span></div> <img class='direct-chat-img' src='https://img.icons8.com/color/36/000000/administrator-male.png'alt='message user image'> <div class='direct-chat-text'>".stripslashes(htmlspecialchars($text))."</div>";
            Storage::append($chat->address, $contents);
            DB::table('chat_sessions')->where('name',$name)->update(['updated_at'=>now()]);
            $details = ['message'=> ['text'=> stripslashes(htmlspecialchars($text)),'name'=>session('name')]];
            if(count($admins) > 0){
                Notification::send($admins, new  NewAdminChat($details));
            }
        }
    }

    public function isSetSession(){
        $session = DB::table('chat_sessions')->where('name',session('name'))->first();

        if(auth()->check() && auth()->user()->user_type == 1){
            return response()->json(['status' => 2]);
        }
        elseif(session('name') && $session !=  null){
                return response()->json(['status' => 0]);

        }
        elseif(!session('name') || $session == null){
            return response()->json(['status' => 1]);
        }

    }

    public function start(Request $request){
        $inputs= $request->all();
        $session = DB::table('chat_sessions')->where('name',session('name'))->first();


        if(session('name') && $session != null){
            $session = DB::table('chat_sessions')->where('name',session('name'))->first();
            if($session != null){
                Storage::append($session->address, 'hi again');
                return response()->json(['status' => true]);
            }else{
                return response()->json(['status' => false]);
            }
        }else{
            $name = $inputs['name'].rand(10,100);
            $address = 'chat/'.$name.'.txt';
            Storage::put($address, 'new chat start');
            DB::table('chat_sessions')->insert(['name'=>$name,'address'=> $address,'created_at'=>now()]);
            session(['name'=>$name]);
            return response()->json(['status' => true]);
        }

    }


    public function log(){

    $name=$_GET['name'] ?? null;
    $contents = null;
    $session = DB::table('chat_sessions')->where('name',session('name'))->first();

    if(auth()->check() && auth()->user()->user_type == 1){

        if($name != null){
            $admin= DB::table('chat_sessions')->where('name',$name)->first();
            if(file_exists(Storage::path($admin->address))){
                $contents = Storage::get($admin->address);
            }else{
                $contents = '';
            }
            return response()->json(['contents' => $contents,'name'=> $name]);

        }else{

            $date = DB::table('chat_sessions')->max('updated_at');
            $admin= DB::table('chat_sessions')->where('updated_at',$date)->first();
            if($admin != null){
                if(file_exists(Storage::path($admin->address))){
                    $contents = Storage::get($admin->address);
                    return response()->json(['contents' => $contents,'name'=> $admin->name]);

                }else{
                    $contents = '';


            }}else{
                return response()->json(['contents' => false]);

            }


        }

    }

    elseif(session('name') && $session != null){
        $session = DB::table('chat_sessions')->where('name',session('name'))->first();
        if(file_exists(Storage::path($session->address))){
            $contents = Storage::get($session->address);

        }else{
            $contents = '';
        }
    }
if($contents != null){
    return response()->json(['contents' => $contents]);

}else{
    return response()->json(['contents' => false]);
}
}


    public function destroySession(){
        $session = session()->forget('name');
        return response()->json(['status' => true]);
    }



    public function destroy(){
        $id = $_POST['id'];
        $chat = DB::table('chat_sessions')->where('id',$id)->first();
        if(file_exists(Storage::path($chat->address))){
            $contents = Storage::delete($chat->address);
        }
        $chat = DB::table('chat_sessions')->where('id',$id)->delete();
        return redirect()->back();
    }


}
