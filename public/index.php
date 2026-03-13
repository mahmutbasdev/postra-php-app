<?php
declare(strict_types=1);
session_start();

ini_set('display_errors', '1');
error_reporting(E_ALL);


require_once __DIR__ . '/../core/Router.php';

$url = $_SERVER['REQUEST_URI'];


$router = new Router($url);

$router->get('/', 'HomeController@index');
$router->get('/signup', 'SignupController@show');
$router->post('/signup', 'SignupController@registerUser');
$router->get('/login', 'LoginController@show');
$router->post('/login', 'LoginController@login');
$router->get('/dashboard', 'DashboardController@index');
$router->get('/logout', 'LogoutController@index');
$router->get('/posts/create', 'PostController@create');
$router->post('/posts/store', 'PostController@store');
$router->get('/posts', 'PostController@index');
$router->get('/posts/myPosts', 'PostController@myPosts');
$router->get('/posts/edit', 'PostController@edit');
$router->post('/posts/update', 'PostController@update');
$router->post('/posts/delete', 'PostController@delete');

$router->dispatch();