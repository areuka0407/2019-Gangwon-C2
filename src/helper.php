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

function admin(){
    return user() && user()->identity === "admin" ? user() : null;
}

function redirect($url, $message = null, $type = 0){
    header("Location: {$url}");
    if($message){
        session()->set("toast-message", $message);
        session()->set("toast-type", $type);
    }
    exit;
}

function back($message = null, $type = 0){
    if($message) {
        session()->set("toast-message", $message);
        session()->set("toast-type", $type);
    }
    echo "<script>";
    echo "history.back();";
    echo "</script>";
    exit;
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

function scheduleName($scheduleObj){
    $result = "등록 행사(";
    $result .= date("Y-m-d", strtotime($scheduleObj->startTime));
    $result .= "~";
    $result .= date("Y-m-d", strtotime($scheduleObj->endTime));
    $result .= ")";
    return $result;
}