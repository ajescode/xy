<?php

namespace Engine;

use Config;

abstract class Controller
{

    protected $controllerName;
    protected $database;

    /** @var \Engine\Session */
    protected $session;
    protected $template;
    protected $templateData = [];
    protected $config;
    protected $twig;

    public function __construct()
    {
        //Configs loading
        $this->config = new Config();

        //Datbase connection establishment
        $this->database = new \Database\Database($this->config::DB_HOST, $this->config::DB_DATABASE, $this->config::DB_PORT, $this->config::DB_USER, $this->config::DB_PASS);

        //Twig engine loading
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $this->twig = new \Twig\Environment($loader);

        //monitor user session
        if (isset($_SESSION['userId'])) {
            $this->session = new \Engine\Session($this->database->getUser($_SESSION['userId']));
        } else {
            $this->session = new \Engine\Session();
        }

        //perform controller action before view
        $this->preAction();
        $this->prepareViewData();
    }

    protected function preAction()
    {

    }

    public function setName(string $controllerName)
    {
        $this->controllerName = $controllerName;
    }

    public function render()
    {
        echo $this->twig->render('header.twig', $this->getHeaderData());
        echo $this->twig->render($this->controllerName . '.twig', $this->getTemplateData());
        echo $this->twig->render('footer.twig', $this->getFooterData());
    }

    protected function getHeaderData(): array
    {
        return [
            'is_logged' => $this->session->isUserLogged(),
            'is_admin' => $this->session->isUserAdmin(),
            'user_login' => $this->session->getLogin()
        ];
    }

    protected function getFooterData(): array
    {
        return [];
    }

    protected function getTemplateData(): array
    {
        return $this->templateData;
    }

    protected function templateDataAppend(string $name, $data)
    {
        $this->templateData[$name] = $data;
    }


    abstract protected function prepareViewData();

}