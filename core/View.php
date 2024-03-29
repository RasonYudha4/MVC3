<?php

namespace app\core;

class View 
{
    public string $title = '';

    // Method yang berfungsi sebagai wadah untuk menentukan layout yang akan digunakan
    public function layoutContent() 
    {
        $layout = Application::$app->layout;
        if(Application::$app->controller){
            $layout = Application::$app->controller->layout;
        }
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
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent($viewContent) 
    {
        $layoutContent = $this->layoutContent();

        // Menukar string {{content}} yang terdapat pada $viewContent menjadi semua nilai yang terdapat di $layoutContent 
        return str_replace('{{content}}', $viewContent, $layoutContent);
        include_once Application::$ROOT_DIR."/views/$view.php";
    }
}