<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function readAll(){

        $notifications = Notification::where('type','App\Notifications\NewComment') ->where('read_at', null)->get();
        if(!empty($notifications)){
            foreach($notifications as $notification){
               $result = $notification->update(['read_at'=> now()]);
        }}


        if($result){
            return response()->json(['comm' => true]);
        }
        else{
            return response()->json(['comm' => false]);
        }
    }

    public function AdminReadAll(){

        $notifications = Notification::where('type','App\Notifications\AdminNewComment') ->where('read_at', null)->get();
        if(!empty($notifications)){
            foreach($notifications as $notification){
               $result = $notification->update(['read_at'=> now()]);
        }}


        if($result){
            return response()->json(['comm' => true]);
        }
        else{
            return response()->json(['comm' => false]);
        }
    }

    public function newUser(){

        $notifications = Notification::where('type','App\Notifications\newUser') ->where('read_at', null)->get();
        if(!empty($notifications)){
            foreach($notifications as $notification){
               $result = $notification->update(['read_at'=> now()]);
        }}


        if($result){
            return response()->json(['comm' => true]);
        }
        else{
            return response()->json(['comm' => false]);
        }
    }

        public function adminNewChat(){
        $name =$_GET['name'];
        if(auth()->check() && auth()->user()->user_type == 1){

            $user = auth()->user();

            if(!empty($user->unreadNotifications)){


                    foreach($user->unreadNotifications as $unreadNotification){

                        if($unreadNotification->type == 'App\Notifications\NewAdminChat'){

                            if($unreadNotification->data['message']['name'] == $name){

                                $result = $unreadNotification->delete();

                            }
                        }
                    }
                    return response()->json(['comm' => true]);


                }
        }

     return response()->json(['comm' => false]);
    }

}
