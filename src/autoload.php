<?php

function classLoader($fullName){
    $prefix = "Areuka";
    $length = strlen($prefix);
    
    if(strncmp($fullName, $prefix, $length) === 0){
        $className = substr($fullName, $length);
        $classPath = __SRC.$className.".php";


        if(is_file($classPath)){
            require $classPath;
        }
    }
}

spl_autoload_register("classLoader");