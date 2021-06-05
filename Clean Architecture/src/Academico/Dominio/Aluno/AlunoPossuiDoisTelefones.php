<?php

namespace Alura\Arquitetura\Academico\Dominio\Aluno;

class AlunoPossuiDoisTelefones extends \DomainException
{
  public function __construct()
  {
    parent::__construct('Aluno ja cadastrou dois telefones.');
  }
}
