<?php


namespace Alura\Arquitetura\Infra\Aluno;


use Alura\Arquitetura\Dominio\Aluno\Aluno;
use Alura\Arquitetura\Dominio\Aluno\AlunoNaoEncontrado;
use Alura\Arquitetura\Dominio\Aluno\RepositorioDeAluno;
use Alura\Arquitetura\Dominio\Cpf;

class RepositorioDeAlunoEmMemoria implements RepositorioDeAluno
{
  /** @var Aluno[] */
  private array $alunos = [];

  public function adicionar(Aluno $aluno): void
  {
    $this->alunos[] = $aluno;
  }

  public function buscarPorCpf(Cpf $cpf): Aluno
  {
    $alunosFiltrados = array_filter($this->alunos, fn ($aluno) => $aluno->cpf() == $cpf);

    if (count($alunosFiltrados) === 0) {
      throw new AlunoNaoEncontrado($cpf);
    }

    if (count($alunosFiltrados) > 1) {
      throw new \DomainException('Ocorreu um erro ao realizar a busca no bando de dados. Contate o suporte.');
    }

    return $alunosFiltrados[0];
  }

  /**
   * @inheritDoc
   */
  public function buscarTodos(): array
  {
    return $this->alunos;
  }
}
