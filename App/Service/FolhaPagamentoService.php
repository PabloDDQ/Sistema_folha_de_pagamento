<?php

namespace App\Service;

use App\DAO\FolhaPagamentoDAO;
use App\Model\FolhaPagamento;

class FolhaPagamentoService
{
    private FolhaPagamentoDAO $folhaPagamentoDAO;

    public function __construct(FolhaPagamentoDAO $folhaPagamentoDAO)
    {
        $this->folhaPagamentoDAO = $folhaPagamentoDAO;
    }

    public function calcularSalario(FolhaPagamento $folhaPagamento): float
    {
        $this->validarFolhaPagamento($folhaPagamento);

        $salarioBase = $folhaPagamento->getColaborador()->getSenioridade()->salario();
        $diasTrabalhados = $folhaPagamento->getDiasTrabalhados();
        $extra = $folhaPagamento->getExtra();

        $salarioProporcional = ($salarioBase / 30) * $diasTrabalhados;

        return round($salarioProporcional + $extra, 2);
    }

    public function registrarPagamento(FolhaPagamento $folhaPagamento): FolhaPagamento
    {
        $total = $this->calcularSalario($folhaPagamento);
        $folhaPagamento->setTotalPagamento($total);

        $this->folhaPagamentoDAO->create($folhaPagamento);

        return $folhaPagamento;
    }

    private function validarFolhaPagamento(FolhaPagamento $folhaPagamento): void
    {
        if ($folhaPagamento->getDiasTrabalhados() < 1 || $folhaPagamento->getDiasTrabalhados() > 30) {
            throw new \InvalidArgumentException('Os dias trabalhados devem estar entre 1 e 30.');
        }

        if ($folhaPagamento->getExtra() < 0) {
            throw new \InvalidArgumentException('O valor extra não pode ser negativo.');
        }
    }
}
