<?php
require_once '../../vendor/autoload.php';
require_once '../Routers.php';

$fineapp = new App($routers);
echo $fineapp->run();