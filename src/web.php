<?php

use Areuka\Engine\Router;


/**
 * Main
 */
Router::get("/", "MainController@indexPage");

Router::get("/bimos/info", "MainController@infoPage");
Router::get("/bimos/history", "MainController@historyPage");

Router::get("/reserve", "MainController@reservePage", "user");
Router::post("/reserve", "MainController@reserve", "user");
Router::get("/reserve/remove/{reserve_id}", "MainController@removeReserve", "user");
Router::get("/reserve/graph/{schedule_id}", "MainController@reserveGraph", "user");

Router::get("/booth-map", "MainController@boothPage");


/**
 * Users
 */

 Router::get("/users/join", "UserController@joinPage", "guest");
 Router::post("/users/join", "UserController@join", "guest");

 Router::get("/users/login", "UserController@loginPage", "guest");
 Router::post("/users/login", "UserController@login", "guest");

 Router::get("/users/logout", "UserController@logout", "user");


/**
 * Admin
 */
Router::get("/admin/site-management", "AdminController@managePage", "admin");
Router::post("/admin/site-management", "AdminController@addSchedule", "admin");

Router::get("/admin/request-booth", "AdminController@requestPage", "company");
Router::post("/admin/request-booth", "AdminController@request", "company");


/**
 * AJAX
 */
Router::post("/get-list/booths", "AjaxController@getBooths");
Router::post("/get-list/{tableName}", "AjaxController@getList");
Router::post("/get-item/{tableName}/{id}", "AjaxController@getItem");

Router::execute();