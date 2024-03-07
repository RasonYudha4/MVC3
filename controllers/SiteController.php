<?php
namespace app\controllers;
use app\core\Controller;
use app\core\Application;
use app\core\Request;

class SiteController extends Controller
{
    public function handleContact(Request $request)
    {
        Application::$app->request->getBody();
        return 'Handling submitted data';
    }

    public function contact() 
    {
        return $this->render('contact');
    }
    public function home() 
    {
        $params = [
            'name' => 'Rifki Arza'
        ];
        return $this->render('home', $params);
    }
}