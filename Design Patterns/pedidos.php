<?php

use Alura\DesignPattern\Pedido\CriadorDePedido;
use Alura\DesignPattern\Pedido\TemplatePedido;
use Alura\DesignPattern\Orcamento;
use Alura\DesignPattern\Pedido\Pedido;

require_once 'vendor/autoload.php';

$pedidos = [];
$criadorPedido = new CriadorDePedido();

for ($i = 0; $i < 10000; $i++) {
    $orcamento = new Orcamento();
    $pedido = $criadorPedido->criaPedido('Vinicius Dias', date('Y-m-d'), $orcamento);

    $pedidos[] = $pedido;
}

echo memory_get_peak_usage() . " bytes";
