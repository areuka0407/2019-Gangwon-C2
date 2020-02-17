<?php

use Areuka\Engine\Router;


/**
 * Main
 */
Router::get("/", "MainController@indexPage");
Router::get("/info", "MainController@infoPage");


/**
 * Admin
 */
Router::get("/admin/site-management", "AdminController@managePage");

Router::execute();