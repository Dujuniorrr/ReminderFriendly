<?php

date_default_timezone_set("America/Sao_Paulo");
require __DIR__ . '/../vendor/autoload.php';

$httpServer = require __DIR__ . '/../config/routes.php';

$httpServer->run();
