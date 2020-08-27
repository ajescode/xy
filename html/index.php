<?php
require('../Engine/Router.php');

$controller = \Engine\Router::getController('index');

$controller->render();