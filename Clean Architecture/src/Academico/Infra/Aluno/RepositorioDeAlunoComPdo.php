<?php

namespace Alura\Arquitetura\Academico\Infra\Aluno;

use Alura\Arquitetura\Academico\Dominio\Aluno\{Aluno, AlunoNaoEncontrado, RepositorioDeAluno, Telefone};
use Alura\Arquitetura\Academico\Dominio\Cpf;

class RepositorioDeAlunoComPdo implements RepositorioDeAluno
{
  private \PDO $conexao;

  public function __construct(\PDO $conexao)
  {
    $this->conexao = $conexao;
  }

  public function adicionar(Aluno $aluno): void
  {
    $sql = 'INSERT INTO alunos VALUES (:cpf, :nome, :email);';
    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue('cpf', $aluno->cpf());
    $stmt->bindValue('nome', $aluno->nome());
    $stmt->bindValue('nome', $aluno->email());
    $stmt->execute();

    /** @var Telefone $telefone */
    foreach ($aluno->telefones() as $telefone) {
      $query = 'INSERT INTO telefones VALUES (:ddd, :numero, :cpf_aluno);';
      $stmt = $this->conexao->prepare($query);
      $stmt->bindValue('ddd', $telefone->ddd());
      $stmt->bindValue('numero', $telefone->numero());
      $stmt->bindValue('cpf_aluno', $aluno->cpf());
      $stmt->execute();
    }
  }

  public function buscarPorCpf(Cpf $cpf): Aluno
  {
   $sql = '
    SELECT cpf, nome, email, ddd, numero as numero_telefone
      FROM alunos
    LEFT JOIN telefones ON telefones.cpf_aluno = alunos.cpf
      WHERE alunos.cpf = ?;
   ';

   $stmt = $this->conexao->prepare($sql);
   $stmt->bindValue(1, (string) $cpf);
   $stmt->execute();

   $dadosAluno = $stmt->fetchAll(\PDO::FETCH_ASSOC);
   if(count($dadosAluno) === 0) {
     throw new AlunoNaoEncontrado($cpf);
   }

   return $this->mapearAluno($dadosAluno);
  }

  public function buscarTodos(): array
  {
    $sql = '
      SELECT cpf, nome, email, ddd, numero as numero_telefone
        FROM alunos 
      LEFT JOIN telefones ON telefones.cpf_aluno = alunos.cpf;
    ';
    $stmt = $this->conexao->prepare($sql);

    $listaDeAlunos = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $alunos = [];

    foreach ($listaDeAlunos as $dadosAluno) {
      if (!array_key_exists($dadosAluno['cpf'], $alunos)) {
        $alunos[$dadosAluno['cpf']] = Aluno::comCpfNomeEEmail($dadosAluno['cpf'], $dadosAluno['nome'], $dadosAluno['email']);
      }

      $alunos[$dadosAluno['cpf']]->adicionarTelefone($dadosAluno['ddd'], $dadosAluno['numero_telefone']);
    }
  }

  private function mapearAluno(array $dadosAluno)
  {
    $primeiraLinha = $dadosAluno[0];
    $aluno = Aluno::comCpfNomeEEmail($primeiraLinha['cpf'], $primeiraLinha['nome'], $primeiraLinha['email']);
    $telefones = array_filter($dadosAluno, fn ($linha) => $linha['ddd'] !== null && $linha['numero_telefone'] !== null);
    foreach ($telefones as $linha) {
      $aluno->adicionarTelefone($linha['ddd'], $linha['numero_telefone']);
    }

    return $aluno;
  }
}
