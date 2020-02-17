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

function user(){
    return session()->has("user") ? session()->get("user", true) : null;
}

function redirect($url, $message = null, $type = 0){
    header("Location: {$url}");
    if($message){
        session()->set("toast-message", $message);
        session()->set("toast-type", $type);
    }
}

function back($message = null, $type = 0){
    if($message) {
        session()->set("toast-message", $message);
        session()->set("toast-type", $type);
    }
    // exit;
    echo "<script>";
    echo "history.back();";
    echo "</script>";
}

function view($pageName, $data = []){
    extract($data);

    require __VIEW.DS."template".DS."header.php";
    require __VIEW.DS.$pageName.".php";
    require __VIEW.DS."template".DS."footer.php";
}

function emptyCheck(){
    foreach($_POST as $item){
        if(trim($item) === ""){
            back("모든 정보를 기입해 주시기 바랍니다.");
            exit;
        }
    }
}