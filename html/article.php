<?php
require('../Engine/Router.php');

$controller = \Engine\Router::getController('article');

$controller->render();