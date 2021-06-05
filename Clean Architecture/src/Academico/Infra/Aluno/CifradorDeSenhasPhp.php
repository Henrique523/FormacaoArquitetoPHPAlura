<?php

namespace Alura\Arquitetura\Academico\Infra\Aluno;

use Alura\Arquitetura\Academico\Dominio\Aluno\CifradorDeSenhas;

class CifradorDeSenhasPhp implements CifradorDeSenhas
{

  public function cifrar(string $senha): string
  {
    return password_hash($senha, PASSWORD_ARGON2ID);
  }

  public function verificar(string $senhaEmTexto, string $senhaCifrada): bool
  {
    return password_verify($senhaEmTexto, $senhaCifrada);
  }
}
