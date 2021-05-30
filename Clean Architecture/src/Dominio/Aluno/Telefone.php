<?php

namespace Alura\Arquitetura\Dominio\Aluno;

class Telefone
{
  private string $ddd;
  private string $numero;

  public function __construct(string $ddd, string $numero)
  {
    $this->setDdd($ddd);
    $this->setNumero($numero);
  }

  private function setDdd(string $ddd)
  {
    if (preg_match('/\d{2}/', $ddd) !== 1) {
      throw new \InvalidArgumentException('DDD invalido');
    }

    $this->ddd = $ddd;
  }

  private function setNumero(string $numero)
  {
    if (preg_match('/\d{8,9}/', $numero) !== 1) {
      throw new \InvalidArgumentException('Numero de telefone invalido');
    }

    $this->numero = $numero;
  }

  public function __toString()
  {
    return "({$this->ddd}) {$this->numero}";
  }

}
