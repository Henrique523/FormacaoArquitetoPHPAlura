<?php

namespace Alura\Arquitetura\Dominio\Aluno;

class LogDeAlunoMatriculado
{
  public function reagoAo(AlunoMatriculado $alunoMatriculado): void
  {
    fprintf(
      STDERR,
      'Aluno com CPF $s foi matriculado em %s',
      (string) $alunoMatriculado->cpfAluno(),
      $alunoMatriculado->momento()->format('d/m/Y')
    );
  }
}
