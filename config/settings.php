<?php
// Permitir el encabezado Authorization
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
use Psr\Container\ContainerInterface;

return function (ContainerInterface $container)
{
  $container->set('settings',function()
  {
    $db = require __DIR__ . '/database.php';

    return [
        "db"=>$db
    ];
  });
};