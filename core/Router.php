<?php
namespace app\core;

class Router 
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
    }

    // Method yang berfungsi untuk menyimpan callback ke dalam array routes ketika method yang digunakan adalah get
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    // Method yang berfungsi untuk menyimpan callback ke dalam array routes ketika method yang digunakan adalah post
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }
    
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();

        // Menentukan keberadaan dari url, return false apabila alamat url tidak ditemukan
        $callback = $this->routes[$method][$path] ?? false;
        // Tampilan ketika url tidak menghasilkan apapun
        if ($callback === false) {
            throw new \app\core\exception\NotFoundException();
        }

        if(is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        // Apabila callback berbentuk array, dalam konfigurasinya element pertama dari array merupakan object dari class yang diambil
        if(is_array($callback)) {
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }
        // Digunakan untuk menjalankan callback supaya fitur routing dapat berjalan
        return call_user_func($callback, $this->request, $this->response);
    }
}