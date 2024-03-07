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

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();

        // Memastikan keberadaan dari url, return false apabila alamat url tidak ditemukan
        $callback = $this->routes[$method][$path] ?? false;
        // Tampilan ketika url tidak menghasilkan apapun
        if ($callback === false) {
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
        }

        if(is_string($callback)) {
            return $this->renderView($callback);
        }

        // Apabila callback berbentuk array, dalam konfigurasinya element pertama dari array merupakan object dari class yang diambil
        if(is_array($callback)) {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }
        // Digunakan untuk menjalankan callback supaya fitur routing dapat berjalan
        return call_user_func($callback, $this->request);
    }

    public function renderView($view, $params = []) 
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        // Menukar string {{content}} yang terdapat pada $viewContent menjadi semua nilai yang terdapat di $layoutContent 
        return str_replace('{{content}}', $viewContent, $layoutContent);
        include_once Application::$ROOT_DIR."/views/$view.php";
    }

    public function renderContent($viewContent) 
    {
        $layoutContent = $this->layoutContent();

        // Menukar string {{content}} yang terdapat pada $viewContent menjadi semua nilai yang terdapat di $layoutContent 
        return str_replace('{{content}}', $viewContent, $layoutContent);
        include_once Application::$ROOT_DIR."/views/$view.php";
    }

    public function layoutContent() 
    {
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params) 
    {
        foreach($params as $key => $value) {
            $$key = $value;
        }
    
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}