<?php
namespace Areuka\Engine;

class Router {
    static $pageList = [];

    public function currentURL(){
        return explode("?", $_SERVER['REQUEST_URI'])[0];
    }

    public static function execute(){
        $current_url = self::currentURL();
        
        foreach(self::$pageList as $page){
            $url = $page[0];
            $action = explode("@", $page[1]);
            $conName = "Areuka\\Controller\\{$action[0]}";
            $method = $action[1];

            $regex = preg_replace("/{([^\\/]+)}/", "([^/]+)", $url);
            $regex = preg_replace("/\\//", "\\/", $regex);
            if(preg_match("/^{$regex}$/", $current_url, $matches)){
                unset($matches[0]);
                $con = new $conName();
                $con->{$method}();
                exit;
            }
        }

        echo "해당 페이지가 존재하지 않습니다.";
    }

    public static function __callStatic($name, $arguments)
    {
        if($_SERVER['REQUEST_METHOD'] === strtoupper($name)){
            self::$pageList[] = $arguments;
        }
    }
}