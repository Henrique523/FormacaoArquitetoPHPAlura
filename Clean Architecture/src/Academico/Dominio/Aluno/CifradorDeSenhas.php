<?php

namespace Alura\Arquitetura\Academico\Dominio\Aluno;

interface CifradorDeSenhas
{
  public function cifrar(string $senha): string;
  public function verificar(string $senhaEmTexto, string $senhaCifrada): bool;
}
