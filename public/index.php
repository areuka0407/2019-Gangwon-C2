<?php

session_start();

define("DS", DIRECTORY_SEPARATOR);
define("__ROOT", dirname(__DIR__));
define("__PUBLIC", __DIR__);
define("__SRC", __ROOT.DS."src");


require __SRC.DS."autoload.php";
require __SRC.DS."helper.php";
require __SRC.DS."web.php";
