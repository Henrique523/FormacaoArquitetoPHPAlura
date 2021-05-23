<?php

namespace Alura\DesignPattern;

use Alura\DesignPattern\EstadosOrcamento\Finalizado;
use Alura\DesignPattern\Http\HttpAdapter;

class RegistroOrcamento
{
  private HttpAdapter $http;

  public function __construct(HttpAdapter $http)
  {
    $this->http = $http;
  }
  public function registrar(Orcamento $orcamento): void
  {
    if ($orcamento->estadoAtual instanceof Finalizado) {
      throw new \DomainException('Apenas orcamentos finalizados podem ser registrados na api.');
    }

    $this->http->post('http://api.registrar.orcamento', [
      'valor' => $orcamento->valor,
      'quantidadeItens' => $orcamento->quantidadeItens
    ]);
  }
}
