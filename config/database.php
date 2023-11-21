<?php
$database_config = [
    'driver'=>'mysql',
    'host'=>'127.0.0.1',
    'database'=>'bd_urramba',
    'username'=>'root',
    'password'=>'',
    'charset'=>'utf8',
    'collation'=>'utf8_unicode_ci',
    'prefix'=>''
    
    /*'driver'=>'mysql',
    'host'=>'localhost',
    'database'=>'cobroco_urramba',
    'username'=>'cobroco_user_urramba',
    'password'=>'rramba*2023',
    'charset'=>'utf8',
    'collation'=>'utf8_unicode_ci',
    'prefix'=>''*/
];

$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($database_config);
$capsule->setAsGlobal();
$capsule->bootEloquent();

return $capsule;