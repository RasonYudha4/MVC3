<?php
namespace app\controllers;
use app\core\Controller;
use app\core\Application;
use app\core\Request;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function handleContact(Request $request)
    {
        Application::$app->request->getBody();
        return 'Handling submitted data';
    }

    public function contact(Request $request) 
    {
        $contact = new ContactForm();
        if ($request->isPost()) {
            $contact->loadData($request->getBody());
            if($contact->validate() && $contact->send()) {
                Application::$app->session->setFlash('success', 'Thanks for contacting us');
                return $request->redirect('/contact');
            }
        }
        return $this->render('contact', [
            'model' => $contact
        ]);
    }

    public function home() 
    {
        $params = [
            'name' => 'Rifki Arza'
        ];
        return $this->render('home', $params);
    }
}