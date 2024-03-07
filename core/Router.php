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

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        // Memastikan keberadaan dari url, return false apabila alamat url tidak ditemukan
        $callback = $this->routes[$method][$path] ?? false;
        // Tampilan ketika url tidak menghasilkan apapun
        if ($callback === false) {
            $this->response->setStatusCode(404);
            return "Page does not found";
        }

        if(is_string($callback)) {
            return $this->renderView($callback);
        }

        // Digunakan untuk menjalankan callback supaya fitur routing dapat berjalan
        return call_user_func($callback);
    }

    public function renderView($view) 
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view);
        // Menukar string {{content}} yang terdapat pada $viewContent menjadi semua nilai yang terdapat di $layoutContent 
        return str_replace('{{content}}', $viewContent, $layoutContent);
        include_once Application::$ROOT_DIR."/views/$view.php";
    }

    public function layoutContent() 
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/main.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view) 
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}