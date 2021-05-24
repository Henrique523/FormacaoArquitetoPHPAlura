<?php

use Alura\DesignPattern\PdoConnection;

require_once 'vendor/autoload.php';

$pdo = PdoConnection::getInstance('sqlite::memory:');
//$pdo->query('');

$pdo2  = PdoConnection::getInstance('sqlite::memory:');
//$pdo->query('');

var_dump($pdo, $pdo2);
