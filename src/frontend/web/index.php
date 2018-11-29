<?php
require_once '../../vendor/autoload.php';
require_once '../../config.php';
require_once '../routers.php';


$fineapp = new App();
echo $fineapp->run();