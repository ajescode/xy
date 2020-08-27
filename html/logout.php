<?php
require('../Engine/Router.php');

$controller = \Engine\Router::getController('logout');

$controller->render();