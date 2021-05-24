<?php

namespace Alura\DesignPattern\NotaFiscal;

use Alura\DesignPattern\ItemOrcamento;

abstract class ConstrutorNotaFiscal
{
    public NotaFiscal $notaFiscal;

    public function __construct()
    {
        $notaFiscal = new NotaFiscal();
        $this->notaFiscal = $notaFiscal;
        $this->notaFiscal->dataEmissao = new \DateTimeImmutable();
    }

    public function paraEmpresa(string $cnpj, string $razaoSocial)
    {
        $this->notaFiscal->cnpj = $cnpj;
        $this->notaFiscal->razaoSocialEmpresa = $razaoSocial;

        return $this;
    }

    public function comItem(ItemOrcamento $item)
    {
        $this->notaFiscal->itens[] = $item;

        return $this;
    }

    public function comObservacoes(string $observacoes)
    {
        $this->notaFiscal->observacoes = $observacoes;

        return $this;
    }

    public function comDataEmissao(\DateTimeInterface $dataEmissao)
    {
        $this->notaFiscal->dataEmissao = $dataEmissao;

        return $this;
    }

    abstract public function constroi(): NotaFiscal;
}