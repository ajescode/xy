<?php
require('../Engine/Router.php');

$controller = \Engine\Router::getController('add');

$controller->render();