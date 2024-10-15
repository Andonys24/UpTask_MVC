<?php

$db = mysqli_connect(
    getenv('MYSQL_HOST') ?: 'mysql_db', 
    getenv('MYSQL_USER'), 
    getenv('MYSQL_PASSWORD'), 
    getenv('MYSQL_DATABASE')
);

$db->set_charset('utf8');

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}