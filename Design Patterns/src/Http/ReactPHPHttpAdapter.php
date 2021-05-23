<?php

namespace Alura\DesignPattern\Http;

class ReactPHPHttpAdapter implements HttpAdapter
{
  public function post(string $url, array $data = []): void
  {
    // instancio os dados;
    // preparo os dados;
    // faco a requisicao
    echo "ReactPHP";
  }
}
