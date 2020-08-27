<?php

namespace Engine;

class Router
{
    public static function getController(string $view): Controller
    {
        $controller = null;
        require('../Controller/' . ucfirst($view) . '.php');
        switch ($view) {
            case 'index':
                $controller = new \Controller\IndexController();
                break;
            case 'login':
                $controller = new \Controller\LoginController();
                break;
            case 'article':
                $controller = new \Controller\ArticleController();
                break;
            case 'imprint':
                $controller = new \Controller\ImprintController();
                break;
            case 'logout':
                $controller = new \Controller\LogoutController();
                break;
            case 'add':
                $controller = new \Controller\AddController();
                break;
        }
        $controller->setName($view);
        return $controller;
    }
}

spl_autoload_register(function ($className) {
    $className = $str = str_replace('\\', '/', $className);
    include_once '../' . $className . '.php';
});

//Composer loading
require_once '../vendor/autoload.php';

session_start();