<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once '../../vendor/autoload.php';
require_once '../../config.php';
require_once '../routers.php';


$fineapp = new App();
echo $fineapp->run();