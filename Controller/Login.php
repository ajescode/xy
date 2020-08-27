<?php

namespace Controller;

class LoginController extends \Engine\Controller
{
    protected function preAction()
    {
        if ($_POST['login']) {
            $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            $userCheck = $this->database->checkUserPassword($login);

            if (password_verify($password, $userCheck['password'])) {
                $_SESSION['userId'] = $userCheck['id'];
                header('Location:index.php');
            } else {
                $this->templateDataAppend('incorrect_password', true);
            }
        }
    }

    protected function prepareViewData()
    {
    }
}