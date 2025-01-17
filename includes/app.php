<?php

use Dotenv\Dotenv;
use Model\ActiveRecord;

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__ . '/../', '.env');
$dotenv->safeLoad();
require 'database.php';
require 'funciones.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);