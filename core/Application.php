<?php

namespace app\core;

class Application 
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public static Application $app;

    // $rootPath merupakan entry url yang merupakan file index di directory public
    public function __construct($rootPath)
    {
        // Menyimpan nilai dari entry url ke attribute static $ROOT_DIR
        self::$ROOT_DIR = $rootPath;
        // Mendeklarasikan attribute static $app yang merupakan object dari class Application sebagai variabel $this
        self::$app = $this;
        // Pembuatan object
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}