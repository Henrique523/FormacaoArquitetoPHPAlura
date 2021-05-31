<?php

namespace Alura\Arquitetura\Aplicacao\Indicacao;

interface EnviaEmailIndicacao
{
  public function enviaPara(Aluno $alunoIndicado): void;
}
