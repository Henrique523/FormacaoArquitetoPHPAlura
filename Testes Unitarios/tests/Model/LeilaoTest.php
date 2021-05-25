<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
  public function testLeilaoNaoDeveReceberLancesRepetidos()
  {
    $this->expectException(\DomainException::class);
    $this->expectExceptionMessage('Usuario nao pode propor 2 lances consecutivos');

    $leilao = new Leilao('Variante');
    $ana = new Usuario('Ana');

    $leilao->recebeLance(new Lance($ana, 1000));
    $leilao->recebeLance(new Lance($ana, 1500));
  }

  public function testLeilaoNaoDeveAceitarMaisDeCincoLancesPorUsuario()
  {
    $this->expectException(\DomainException::class);
    $this->expectExceptionMessage('Usuario nao pode propor mais de 5 lances por leilao');

    $leilao = new Leilao('Variante');
    $ana = new Usuario('Ana');
    $joao = new Usuario('Joao');

    $leilao->recebeLance(New Lance($joao, 1000));
    $leilao->recebeLance(New Lance($ana, 1100));
    $leilao->recebeLance(New Lance($joao, 1200));
    $leilao->recebeLance(New Lance($ana, 1300));
    $leilao->recebeLance(New Lance($joao, 1400));
    $leilao->recebeLance(New Lance($ana, 1500));
    $leilao->recebeLance(New Lance($joao, 1600));
    $leilao->recebeLance(New Lance($ana, 1700));
    $leilao->recebeLance(New Lance($joao, 1800));
    $leilao->recebeLance(New Lance($ana, 1900));
    $leilao->recebeLance(New Lance($joao, 2000));
  }

  /**
   * @dataProvider geraLances
   */
  public function testLeilaoDeveReceberLances(int $qtdLances, Leilao $leilao, array $valores)
  {
    static::assertCount($qtdLances, $leilao->getLances());

    foreach ($valores as $i => $valorEsperado) {
      static::assertEquals($valorEsperado, $leilao->getLances()[$i]->getValor());
    }
  }

  public function geraLances()
  {
    $joao = new Usuario('Joao');
    $maria = new Usuario('Maria');

    $leilaoCom2Lances = new Leilao('Fiat 147 0km');
    $leilaoCom2Lances->recebeLance(new Lance($joao, 1000));
    $leilaoCom2Lances->recebeLance(new Lance($maria, 2000));

    $leilaoCom1Lance = new Leilao('Fiat 147 0km');
    $leilaoCom1Lance->recebeLance(new Lance($joao, 1000));

    return [
      'leilao-dois-lances' => [2, $leilaoCom2Lances, [1000, 2000]],
      'leilao-um-lance' => [1, $leilaoCom1Lance, [1000]]
    ];
  }
}
