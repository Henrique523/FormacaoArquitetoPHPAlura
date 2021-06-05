<?php

namespace Alura\Arquitetura\Academico\Dominio\Aluno;


use Alura\Arquitetura\Academico\Dominio\{Evento, OuvinteDeEvento};

class LogDeAlunoMatriculado extends OuvinteDeEvento
{
  public function reagoAo(Evento $alunoMatriculado): void
  {
    fprintf(
      STDERR,
      'Aluno com CPF $s foi matriculado em %s',
      (string) $alunoMatriculado->cpfAluno(),
      $alunoMatriculado->momento()->format('d/m/Y')
    );
  }

  public function sabeProcessar(Evento $evento): bool
  {
    return $evento instanceof AlunoMatriculado;
  }

  /**
   * @param AlunoMatriculado $evento
   */
  public function reageAo(Evento $alunoMatriculado): void
  {
    fprintf(
      STDERR,
      'Aluno com CPF %s foi matriculado na data %s',
      (string) $alunoMatriculado->cpfAluno(),
      $alunoMatriculado->momento()->format('d/m/Y'),
    );
  }
}
