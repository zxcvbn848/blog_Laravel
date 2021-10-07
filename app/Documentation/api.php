<?php

require('vendor/autoload.php');
$openapi = \OpenApi\Generator::scan([base_path()]);
header('Content-Type: application/x-yaml');
echo $openapi->toYaml();
