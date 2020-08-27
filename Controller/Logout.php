<?php

namespace Controller;

class LogoutController extends \Engine\Controller
{

    public function preAction()
    {
        unset($_SESSION['userId']);

        header('Location:index.php');
        exit;
    }


    protected function prepareViewData()
    {
    }
}