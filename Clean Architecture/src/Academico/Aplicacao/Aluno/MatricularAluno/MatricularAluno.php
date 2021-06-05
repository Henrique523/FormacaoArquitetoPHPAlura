<?php

namespace Alura\Arquitetura\Academico\Aplicacao\Aluno\MatricularAluno;

use Alura\Arquitetura\Academico\Dominio\Aluno\{AlunoMatriculado, RepositorioDeAluno};
use Alura\Arquitetura\Academico\Dominio\PublicadorDeEvento;

class MatricularAluno
{
  private RepositorioDeAluno $repositorioDeAluno;
  private PublicadorDeEvento $publicador;

  public function __construct(RepositorioDeAluno $repositorioDeAluno, PublicadorDeEvento $publicador)
  {
    $this->repositorioDeAluno = $repositorioDeAluno;
    $this->publicador = $publicador;
  }

  public function executa(MatricularAlunoDto $dados): void
  {
    $aluno = Aluno::comCpfNomeEEmail($dados->cpfAluno, $dados->nomeAluno, $dados->emailAluno);
    $this->repositorioDeAluno->adicionar($aluno);

    $this->publicador->publicar(new AlunoMatriculado($aluno->cpf()));
  }
}
