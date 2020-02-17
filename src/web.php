<?php

use Areuka\Engine\Router;


/**
 * Main
 */
Router::get("/", "MainController@indexPage");
Router::get("/bimos/info", "MainController@infoPage");
Router::get("/bimos/history", "MainController@historyPage");


/**
 * Users
 */

 Router::get("/users/join", "UserController@joinPage", "guest");
 Router::post("/users/join", "UserController@join", "guest");

 Router::get("/users/login", "UserController@loginPage", "guest");
 Router::post("/users/login", "UserController@login", "guest");


/**
 * Admin
 */
Router::get("/admin/site-management", "AdminController@managePage");

Router::execute();