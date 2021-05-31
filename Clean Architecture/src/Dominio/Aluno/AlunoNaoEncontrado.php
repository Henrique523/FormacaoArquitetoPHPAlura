<?php

namespace Alura\Arquitetura\Dominio\Aluno;

use Throwable;

class AlunoNaoEncontrado extends \DomainException
{
  public function __construct(Cpf $cpf)
  {
    parent::__construct("Aluno com CPF {$cpf} nao encontrado");
  }
}
