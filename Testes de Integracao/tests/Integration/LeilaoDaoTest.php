<?php


namespace Alura\Leilao\Tests\Integration\Dao;


use Alura\Leilao\Infra\ConnectionCreator;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Dao\Leilao as LeilaoDao;
use PHPUnit\Framework\TestCase;

class LeilaoDaoTest extends TestCase
{
  private static \PDO $pdo;
  private static Leilao $leilaoVariante;
  private static Leilao $leilaoFiat147;
  private static LeilaoDao $leilaoDao;

  /** @var Leilao[]  */
  private array $leiloesNaoFinalizados;

  /** @var Leilao[]  */
  private array $leiloesFinalizados;

  public static function setUpBeforeClass(): void
  {
    self::$pdo = new \PDO('sqlite::memory:');
    $sql = 'create table leiloes (id INTEGER primary key, descricao TEXT, finalizado BOOL, dataInicio TEXT);';
    self::$pdo->exec($sql);

    self::$leilaoVariante = new Leilao('Variante 0km');
    self::$leilaoFiat147 = new Leilao('Fiat 147 0km');
    self::$leilaoDao = new LeilaoDao(self::$pdo);
  }

  protected function setUp(): void
  {
    self::$pdo->beginTransaction();

    self::$leilaoFiat147->finaliza();

    self::$leilaoDao->salva(self::$leilaoVariante);
    self::$leilaoDao->salva(self::$leilaoFiat147);

    $this->leiloesNaoFinalizados = self::$leilaoDao->recuperarNaoFinalizados();
    $this->leiloesFinalizados = self::$leilaoDao->recuperarFinalizados();
  }

  public function testBuscaLeiloesNaoFinalizados()
  {
    self::assertCount(1, $this->leiloesNaoFinalizados);
    self::assertContainsOnlyInstancesOf(Leilao::class, $this->leiloesNaoFinalizados);
    self::assertSame('Variante 0km', $this->leiloesNaoFinalizados[0]->recuperarDescricao());
  }

  public function testBuscaLeiloesFinalizados()
  {
    self::assertCount(1, $this->leiloesFinalizados);
    self::assertContainsOnlyInstancesOf(Leilao::class, $this->leiloesFinalizados);
    self::assertSame('Fiat 147 0km', $this->leiloesFinalizados[0]->recuperarDescricao());
  }

  public function testAoAtualizarLeilaoStatusDeveSerAlterado()
  {
    $leilao = new Leilao('Brasilia Amarela');
    $leilao = self::$leilaoDao->salva($leilao);
    $leiloes = self::$leilaoDao->recuperarNaoFinalizados();
    self::assertCount(2, $leiloes);
    self::assertSame('Brasilia Amarela', $leiloes[1]->recuperarDescricao());

    $leilao->finaliza();

    self::$leilaoDao->atualiza($leilao);

    $leiloes = self::$leilaoDao->recuperarFinalizados();
    self::assertCount(2, $leiloes);
    self::assertSame('Brasilia Amarela', $leiloes[1]->recuperarDescricao());
  }

  protected function tearDown(): void
  {
    self::$pdo->rollBack();
  }
}
