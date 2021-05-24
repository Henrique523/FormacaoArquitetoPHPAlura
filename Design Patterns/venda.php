<?php

use Alura\DesignPattern\Venda\VendaProdutoFactory;
use Alura\DesignPattern\Venda\VendaServicoFactory;

require_once 'vendor/autoload.php';

$fabricaVenda = new VendaProdutoFactory(1000);
$venda = $fabricaVenda->criarVenda();
$imposto = $fabricaVenda->imposto();

var_dump($venda, $imposto);
