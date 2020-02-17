<?php
namespace Areuka\Engine;

class Router {
    static $pageList = [];

    private function check($perType){
        if($perType === null) return true;
        else if($perType === "user" && !user()){
            redirect("/users/login", "로그인 후 이용하실 수 있습니다.");
            exit;
        }
        else if($perType === "guest" && user()){
            redirect("/", "로그인 후엔 이용하실 수 없습니다.");
            exit;
        }
        else if($perType === "admin" && !admin()){
            redirect("/", "관리자만 접근 가능합니다.");
            exit;
        }
    }

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
            $permission = isset($page[2]) ? $page[2] : null;
            
            $regex = preg_replace("/{([^\\/]+)}/", "([^/]+)", $url);
            $regex = preg_replace("/\\//", "\\/", $regex);
            if(preg_match("/^{$regex}$/", $current_url, $matches)){
                self::check($permission);
                
                unset($matches[0]);
                $con = new $conName();
                $con->{$method}(...$matches);
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