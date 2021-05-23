<?php


require_once "vendor/autoload.php";

use Alura\DesignPattern\AcoesAoGerarPedido\{CriarPedidoNoBanco, EnviarPedidoPorEmail, LogGerarPedido};
use Alura\DesignPattern\GerarPedido;
use Alura\DesignPattern\GerarPedidoHandler;

$valorOrcamento = $argv[1];
$numeroDeItens = $argv[2];
$nomeCliente = $argv[3];

$gerarPedido = new GerarPedido($valorOrcamento, $numeroDeItens, $nomeCliente);
$gerarPedidoHandler = new GerarPedidoHandler();

$gerarPedidoHandler->adicionarAcaoAoGerarPedido(new CriarPedidoNoBanco());
$gerarPedidoHandler->adicionarAcaoAoGerarPedido(new EnviarPedidoPorEmail());
$gerarPedidoHandler->adicionarAcaoAoGerarPedido(new LogGerarPedido());

$gerarPedidoHandler->execute($gerarPedido);
