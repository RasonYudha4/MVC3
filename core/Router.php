<?php
namespace app\core;

class Router 
{
    public Request $request;
    protected array $routes = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        // Memastikan keberadaan dari url, return false apabila alamat url tidak ditemukan
        $callback = $this->routes[$method][$path] ;
        // Tampilan ketika url tidak menghasilkan apapun
        if ($callback === false) {
            echo "Page does not found";
            exit;
        }

        // Digunakan untuk menjalankan callback supaya fitur routing dapat berjalan
        echo call_user_func($callback);
    }
}