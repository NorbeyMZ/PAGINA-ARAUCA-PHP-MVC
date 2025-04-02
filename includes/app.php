<?php 
use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
$dontenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dontenv->safeLoad();

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos

ActiveRecord::setDB($db);