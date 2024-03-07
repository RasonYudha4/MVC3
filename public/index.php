<?php

require_once __DIR__.'/../vendor/autoload.php';
use app\core\Application;

$app = new Application();


//Mengkonfigurasikan route apa saja yang exist pada program ini
$app->router->get('/', function(){
    return "Hello";
});
$app->router->get('/contact', function(){
    return "Contact";
});

$app->run();