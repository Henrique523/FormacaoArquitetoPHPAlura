<?php

namespace Alura\Arquitetura\Dominio;

class Email
{
  private string $endereco;

  public function __construct(string $endereco)
  {
    if (filter_var($endereco, FILTER_VALIDATE_EMAIL) === false) {
      throw new \InvalidArgumentException('Endereco de e-mail invalido');
    }
    $this->endereco = $endereco;
  }

  public function __toString()
  {
    return $this->endereco;
  }
}
