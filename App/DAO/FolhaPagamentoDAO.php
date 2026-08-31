<?php

namespace App\DAO;

use App\Conexao;
use App\Model\FolhaPagamento;

class FolhaPagamentoDAO
{
    public function create(FolhaPagamento $folhaPagamento)
    {
        $sql = 'INSERT INTO tbl_folhaPagamento (colaborador_ID, dias_trabalhados, extra, total_pagamento, dia_lancamento_pagamento) VALUES (?, ?, ?, ?, ?)';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->bindValue(1, $folhaPagamento->getColaborador()->getId());
        $stmt->bindValue(2, $folhaPagamento->getDiasTrabalhados());
        $stmt->bindValue(3, $folhaPagamento->getExtra());
        $stmt->bindValue(4, $folhaPagamento->getTotalPagamento());
        $stmt->bindValue(5, $folhaPagamento->getDiaLancamentoPagamento()->format('Y-m-d'));
        $stmt->execute();
    }

    public function read()
    {
        $sql = 'SELECT * FROM tbl_folhaPagamento';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0):
            $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        else:
            return [];
        endif;
    }

    public function update(FolhaPagamento $folhaPagamento)
    {
        $sql = 'UPDATE tbl_folhaPagamento SET colaborador_ID = ?, dias_trabalhados = ?, extra = ?, total_pagamento = ?, dia_lancamento_pagamento = ? WHERE ID_folhaPagamento = ?';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->bindValue(1, $folhaPagamento->getColaborador()->getId());
        $stmt->bindValue(2, $folhaPagamento->getDiasTrabalhados());
        $stmt->bindValue(3, $folhaPagamento->getExtra());
        $stmt->bindValue(4, $folhaPagamento->getTotalPagamento());
        $stmt->bindValue(5, $folhaPagamento->getDiaLancamentoPagamento()->format('Y-m-d'));
        $stmt->bindValue(6, $folhaPagamento->getId());
        $stmt->execute();
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM tbl_folhaPagamento WHERE ID_folhaPagamento = ?';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
}
