<?php


use Carbon\Carbon;
use Illuminate\Support\Str;

function hideExit($class){
    if(auth()->check() && auth()->user()->user_type == 1){
        return $class;
    }else{
        return '';

    }
}

function dateDifference($date){
    $newDateTime = Carbon::now()->addDay($date)->format('Y-m-d');

    return Carbon::parse($date)->diffForHumans();
}


