<?php

namespace Alura\DesignPattern\Log;

abstract class LogManager
{
    public function log(string $severidade, string $mensagem): void
    {
        /** @var LogWritter $logWriter */
        $logWriter = $this->criarLogWritter();

        $dataHoje = date('d/m/Y');
        $mensagemFormatada = "[$dataHoje][$severidade] - $mensagem";
        $logWriter->escreve($mensagemFormatada);
    }

    abstract public function criarLogWritter(): LogWritter;
}