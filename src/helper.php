<?php

function dump(){
    foreach(func_get_args() as $arg){
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function dd(){
    dump(...func_get_args());
    exit;
}

function session(){
    return new Areuka\Engine\Session();
}

function redirect($url, $message){
    header("Location: {$url}");
    session()->set("toast-message", $message);
}

function back($message = null){
    echo "<script>";
    if($message) echo "alert('$message');";
    echo "history.back();";
    echo "</script>";
}