<?php

namespace Alura\DesignPattern;

use Alura\DesignPattern\AcoesAoGerarPedido\{AcaoAposGerarPedido};

class GerarPedidoHandler
{
  /** @var AcaoAposGerarPedido[] */
  private array $acoesAposGerarPedido = [];

  public function __construct()
  {
  }

  public function adicionarAcaoAoGerarPedido(AcaoAposGerarPedido $acaoAposGerarPedido)
  {
    $this->acoesAposGerarPedido[] = $acaoAposGerarPedido;
  }

  public function execute(GerarPedido $gerarPedido)
  {
    $orcamento = new Orcamento();
    $orcamento->quantidadeItens = $gerarPedido->getNumeroItens();
    $orcamento->valor = $gerarPedido->getValorOrcamento();

    $pedido = new Pedido();
    $pedido->dataFinalizacao = new \DateTimeImmutable();
    $pedido->nomeCliente = $gerarPedido->getNomeCliente();
    $pedido->orcamento = $orcamento;

    foreach ($this->acoesAposGerarPedido as $acao) {
      $acao->executaAcao($pedido);
    }
  }
}
