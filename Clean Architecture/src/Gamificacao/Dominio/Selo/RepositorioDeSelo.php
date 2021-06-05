<?php

namespace Alura\Arquitetura\Gamificacao\Dominio\Selo;

use Alura\Arquitetura\Academico\Dominio\Cpf;

interface RepositorioDeSelo
{
  public function adiciona(Selo $selo): void;
  public function selosDeAlunoComCpf(Cpf $cpf);
}
