<?php

namespace app\core;

class Application 
{
    public static string $ROOT_DIR;
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public Controller $controller;
    // Tanda tanya mengindikasikan bahwa data bisa bersifat null karena user bisa mengakses website sebagai guest
    public ?DbModel $user;
    public static Application $app;

    // $rootPath merupakan entry url yang merupakan file index di directory public
    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        // Menyimpan nilai dari entry url ke attribute static $ROOT_DIR
        self::$ROOT_DIR = $rootPath;
        // Mendeklarasikan attribute static $app yang merupakan object dari class Application sebagai variabel $this
        self::$app = $this;
        // Pembuatan object
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);

        // Proses pengecekkan eksistensi user pada session
        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
        
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout() 
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}