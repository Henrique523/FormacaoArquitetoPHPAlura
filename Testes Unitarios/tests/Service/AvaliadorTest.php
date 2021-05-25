<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\{Lance, Leilao, Usuario};
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
  private Avaliador $leiloeiro;

  protected function setUp(): void
  {
    $this->leiloeiro = new Avaliador();
  }

  /**
   * @dataProvider entregaLeiloes
   */
  public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
  {
    $this->leiloeiro->avalia($leilao);

    $maiorValor = $this->leiloeiro->getMaiorValor();

    self::assertEquals(2500, $maiorValor);
  }

  /**
   * @dataProvider entregaLeiloes
   */
  public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
  {
    $this->leiloeiro->avalia($leilao);

    $menorValor = $this->leiloeiro->getMenorValor();

    self::assertEquals(1700, $menorValor);
  }

  /**
   * @dataProvider entregaLeiloes
   */
  public function testAvaliadorDeveBuscarTresMaioresValores(Leilao $leilao)
  {
    $this->leiloeiro->avalia($leilao);

    $maiores = $this->leiloeiro->getMaioresLances();
    static::assertCount(3, $maiores);

    static::assertEquals(2500, $maiores[0]->getValor());
    static::assertEquals(2000, $maiores[1]->getValor());
    static::assertEquals(1700, $maiores[2]->getValor());
  }

  public function leilaoemOrdemCrescente()
  {
      $leilao = new Leilao('Fiat 147 0Km');

      $maria = new Usuario('Maria');
      $joao = new Usuario('Joao');
      $ana = new Usuario('Ana');

      $leilao->recebeLance(new Lance($ana, 1700));
      $leilao->recebeLance(new Lance($joao, 2000));
      $leilao->recebeLance(new Lance($maria, 2500));

      return $leilao;
  }

  public function leilaoemOrdemDecrescente()
    {
        $leilao = new Leilao('Fiat 147 0Km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));

        return $leilao;
    }

  public function leilaoemOrdemAleatoria()
    {
        $leilao = new Leilao('Fiat 147 0Km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));

        return $leilao;
    }

  public function entregaLeiloes(): array
    {
        return [
          [$this->leilaoemOrdemCrescente()],
          [$this->leilaoemOrdemDecrescente()],
          [$this->leilaoemOrdemAleatoria()]
        ];
    }
}
