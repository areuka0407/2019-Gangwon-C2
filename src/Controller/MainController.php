<?php
namespace Areuka\Controller;

class MainController {
    function indexPage(){
        view("index");
    }

    function infoPage(){
        view("info");
    }
}