<?php
namespace Areuka\Engine;

class Session {
    public function get($name, $keep = false){
        if($this->has($name)){
            $data = $_SESSION[$name];
            if($keep == false){
                unset($_SESSION[$name]);
            }
            return $data;
        }
        else return null;
    }

    public function set($name, $value){
        $_SESSION[$name] = $value;
    }

    public function has($name){
        return isset($_SESSION[$name]);
    }

    public function remove($name){
        unset($_SESSION[$name]);
    }
}