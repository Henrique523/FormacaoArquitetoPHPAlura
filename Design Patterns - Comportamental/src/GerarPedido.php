<?php

namespace Alura\DesignPattern;

class GerarPedido
{
  private float $valorOrcamento = 0;
  private int $numeroItens = 0;
  private string $nomeCliente = '';

  public function __construct(float $valorOrcamento, int $numeroItens, string $nomeCliente)
  {
    $this->$valorOrcamento = $valorOrcamento;
    $this->$numeroItens = $numeroItens;
    $this->$nomeCliente = $nomeCliente;
  }

  public function getNomeCliente(): string
  {
    return $this->nomeCliente;
  }

  public function getNumeroItens(): int
  {
    return $this->numeroItens;
  }

  public function getValorOrcamento(): float
  {
    return $this->valorOrcamento;
  }
}
