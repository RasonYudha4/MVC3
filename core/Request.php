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

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}