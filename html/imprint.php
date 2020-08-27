<?php
require('../Engine/Router.php');

$controller = \Engine\Router::getController('imprint');

$controller->render();