<?php

use app\controllers\HomeController;

$route->get('', [HomeController::class, 'index']);
