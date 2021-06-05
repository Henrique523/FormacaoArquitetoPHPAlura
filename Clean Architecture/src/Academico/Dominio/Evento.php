<?php

namespace Alura\Arquitetura\Academico\Dominio;

interface Evento
{
  public function momento(): \DateTimeImmutable;
}
