<?php

namespace Alura\Arquitetura\Infra\Aluno;

use Alura\Arquitetura\Dominio\Aluno\CifradorDeSenhas;

class CifradorDeSenhaMd5 implements CifradorDeSenhas
{

  public function cifrar(string $senha): string
  {
    return md5($senha);
  }

  public function verificar(string $senhaEmTexto, string $senhaCifrada): bool
  {
    return md5($senhaEmTexto) === $senhaCifrada;
  }
}
