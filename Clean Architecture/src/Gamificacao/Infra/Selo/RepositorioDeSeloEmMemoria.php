<?php

namespace Alura\Arquitetura\Gamificacao\Infra\Selo;

use Alura\Arquitetura\Academico\Dominio\Cpf;
use Alura\Arquitetura\Gamificacao\Dominio\Selo\{Selo, RepositorioDeSelo};

class RepositorioDeSeloEmMemoria implements RepositorioDeSelo
{
  /** @var Selo[]  */
  private array $selos = [];

  public function adiciona(Selo $selo): void
  {
    $this->selos[] = $selo;
  }

  public function selosDeAlunoComCpf(Cpf $cpf)
  {
    return array_filter($this->selos, fn (Selo $selo) => $selo->cpfAluno() == $cpf);
  }
}
