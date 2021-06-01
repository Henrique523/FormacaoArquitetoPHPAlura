<?php

namespace Alura\Arquitetura\Dominio\Aluno;

use Throwable;

class AlunoPossuiDoisTelefones extends \DomainException
{
  public function __construct()
  {
    parent::__construct('Aluno ja cadastrou dois telefones.');
  }
}
