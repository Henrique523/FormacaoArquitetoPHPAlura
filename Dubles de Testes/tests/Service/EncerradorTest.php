<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Dao\Leilao as LeilaoDao;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Service\Encerrador;
use Alura\Leilao\Service\EnviadorEmail;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;


class EncerradorTest extends TestCase
{
  private Encerrador $encerrador;
  /**
   * @var MockObject
   */
  private EnviadorEmail $enviadorEmail;
  private Leilao $fiat147;
  private Leilao $variant;

  protected function setUp(): void
  {
    $this->fiat147 = new Leilao('Fiat 147', new \DateTimeImmutable('8 days ago'));

    $this->variant = new Leilao('Variant 1972', new \DateTimeImmutable('10 days ago'));

    $leilaoDao = $this->getMockBuilder(LeilaoDao::class)
      ->setConstructorArgs([new \PDO('sqlite::memory:')])
      ->getMock();

    $leilaoDao->method('recuperarNaoFinalizados')->willReturn([$this->fiat147, $this->variant]);
    $leilaoDao->method('recuperarFinalizados')->willReturn([$this->fiat147, $this->variant]);
    $leilaoDao->expects($this->exactly(2))->method('atualiza');

    $leilaoDao->salva($this->fiat147);
    $leilaoDao->salva($this->variant);

    $this->enviadorEmail = $this->createMock(EnviadorEmail::class);

    $this->encerrador = new Encerrador($leilaoDao, $this->enviadorEmail);
  }

  public function testLeiloesComMaisDeUmaSemanaDevemSerEncerrados()
  {

    $this->encerrador->encerra();

    $leiloesFinalizados = [$this->fiat147, $this->variant];
    self::assertCount(2, $leiloesFinalizados);
    self::assertTrue($leiloesFinalizados[0]->estaFinalizado());
    self::assertTrue($leiloesFinalizados[1]->estaFinalizado());
  }

  public function testDeveContinuarOProcessamentoAoEncontrarErroAoEnviarEmail()
  {
    $e = new \DomainException('Erro ao enviar email');
    $this->enviadorEmail
      ->expects($this->exactly(2))
      ->method('notificarTerminoLeilao')
      ->willThrowException($e);

    $this->encerrador->encerra();
  }

  public function testSoDeveEnviarLeilaoPorEmailAposFinalizado()
  {
    $this->enviadorEmail
      ->expects($this->exactly(2))
      ->method('notificarTerminoLeilao')
      ->willReturnCallback(function (Leilao $leilao) {
        static::assertTrue($leilao->estaFinalizado());
      });

    $this->encerrador->encerra();
  }
}
