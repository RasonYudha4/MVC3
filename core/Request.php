<?php

namespace app\core;

class Request 
{
    // Sebuah method yang berfungsi untuk mengambil nilai method url yang merupakan url untuk menuju halaman
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // Menentukan existensi dari parameter url ("?") yang digunakan sebagai pembatas dalam menyaringan method url
        $position = strpos($path, '?');
        // Apabila tidak terdapat parameter url, maka nilai dari $_SERVER['REQUEST_URI'] akan dijadikan sebagai method url
        if ($position === false) {
            return $path;
        }
        // Ketika terdapat parameter ("?") pada url, maka dilakukan penyaringan dari nilai $path dimulai dari index 0 sampai index sebelum existensi dari parameter url ("?")
        return substr($path, 0, $position);
    }

    // Sebuah method yang berfungsi untuk mengambil data berupa jenis method yang dilakukan dalam proses request
    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    // Sebuah method yang digunakan untuk menentukan proses pada setiap method
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