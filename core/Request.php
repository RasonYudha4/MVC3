<?php

namespace app\core;

class Request 
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // Mendeklarasi sebuah parameter ("?") setelah method yang dipilih pada url
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        // Ketika terdapat parameter ("?") pada url, maka hanya return nilai method
        return substr($path, 0, $position);
    }

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody() 
    {
        // Digunakan untuk memsanitasi nilai dari method get dan post
        $body = [];
        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }

    public function isGet() 
    {
        return $this->method() === 'get';   
    }

    public function isPost()
    {
        return $this->method() === 'post';
    }
}