<?php


use Alura\DesignPattern\ItemOrcamento;
use Alura\DesignPattern\NotaFiscal\ConstrutorNotaFiscalProduto;
use Alura\DesignPattern\NotaFiscal\ConstrutorNotaFiscalServico;

require_once 'vendor/autoload.php';

$builder = new ConstrutorNotaFiscalServico();
$item1 = new ItemOrcamento();
$item1->valor = 500;

$item2 = new ItemOrcamento();
$item2->valor = 300;

$item3 = new ItemOrcamento();
$item3->valor = 750;

$notaFiscal = $builder->paraEmpresa('05029600000368', 'AGIR')
    ->comItem($item1)
    ->comItem($item2)
    ->comItem($item3)
    ->comObservacoes('Esta nota fiscao foi construida com um construtor')
    ->constroi();

echo $notaFiscal->valorImpostos;

