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

    // Method yang berfungsi sebagai wadah untuk menentukan layout yang akan digunakan
    public function layoutContent() 
    {
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    // Method yang berfungsi sebagai wadah untuk menentukan content view yang akan digunakan
    // Parameter $params yang digunakan ketika nilai dari index key dibutuhkan dalam penampilan data
    protected function renderOnlyView($view, $params) 
    {
        // Sebuah perulangan yang berfungsi untuk menampilkan nilai dari variabel key ke dalam content view
        foreach($params as $key => $value) {
            $$key = $value;
        }
    
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }

    // Method yang berfungsi untuk menampilkan layout dan content view yang telah diseleksi
    // Pendeklarasi default value untuk array params dilakukan di method ini karena method ini merupakan pembungkus dair method layoutContent() dan renderOnlyView()
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
    
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();

        // Menentukan keberadaan dari url, return false apabila alamat url tidak ditemukan
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
}