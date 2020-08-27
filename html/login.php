<?php
require('../Engine/Router.php');

$controller = \Engine\Router::getController('login');

$controller->render();