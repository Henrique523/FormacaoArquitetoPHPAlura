<?php

namespace Alura\Leilao\Model;

class Leilao
{
  /** @var Lance[] */
  private $lances;
  private string $descricao;
  private bool $finalizado = false;

  public function __construct(string $descricao)
  {
    $this->descricao = $descricao;
    $this->lances = [];
  }

  public function recebeLance(Lance $lance)
  {
    if (!empty($this->lances) && $this->ehDoUltimoUsuario($lance)) {
      throw new \DomainException('Usuario nao pode propor 2 lances consecutivos');
    }

    $totalLancesUsuario = $this->quantidadeLancesPorUsuario($lance->getUsuario());

    if ($totalLancesUsuario >= 5) {
      throw new \DomainException('Usuario nao pode propor mais de 5 lances por leilao');
    }

    $this->lances[] = $lance;
  }

  /**
   * @return Lance[]
   */
  public function getLances(): array
  {
    return $this->lances;
  }

  public function finaliza()
  {
    $this->finalizado = true;
  }

  public function verificaLeilaoFinalizado()
  {
    return $this->finalizado;
  }

  private function ehDoUltimoUsuario(Lance $lance): bool
  {
    $ultimoLance = $this->lances[count($this->lances) - 1];
    return $lance->getUsuario() == $ultimoLance->getUsuario();
  }

  private function quantidadeLancesPorUsuario(Usuario $usuario): int
  {
    $totalLancesUsuario = array_reduce(
      $this->lances,
      function (int $totalAcumulado, Lance $lanceAtual) use ($usuario) {
        if ($lanceAtual->getUsuario() == $usuario) {
          return $totalAcumulado + 1;
        }
        return $totalAcumulado;
      },
      0
    );
    return $totalLancesUsuario;
  }
}
