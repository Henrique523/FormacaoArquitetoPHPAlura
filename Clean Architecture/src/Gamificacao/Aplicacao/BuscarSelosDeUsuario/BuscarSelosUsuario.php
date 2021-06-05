<?php

namespace Alura\Arquitetura\Gamificacao\BuscarSelosDeUsuario;

use Alura\Arquitetura\Gamificacao\Dominio\Selo\RepositorioDeSelo;
use Alura\Arquitetura\Shared\Dominio\Cpf;

class BuscarSelosUsuario
{

  private RepositorioDeSelo $repositorioDeSelo;

  public function __construct(RepositorioDeSelo $repositorioDeSelo)
  {
    $this->repositorioDeSelo = $repositorioDeSelo;
  }

  public function execute(BuscarSelosDeUsuarioDto $dados)
  {
    $cpfAluno = new Cpf($dados->cpfAluno);
    return $this->repositorioDeSelo->selosDeAlunoComCpf($cpfAluno);
  }

}
