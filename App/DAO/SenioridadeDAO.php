<?php

namespace App\DAO;

use App\Conexao;
use App\Model\SenioridadeEnum;

class SenioridadeDAO
{
    public function read(): array
    {
        $sql = 'SELECT * FROM tbl_senioridade';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
    }

    public function buscarIdPorSenioridade(SenioridadeEnum $senioridade): int
    {
        $sql = 'SELECT ID_senioridade FROM tbl_senioridade WHERE senerioridade = ? LIMIT 1';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->bindValue(1, $senioridade->value);
        $stmt->execute();

        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($resultado === false) {
            throw new \RuntimeException('Senioridade não cadastrada no banco de dados.');
        }

        return (int) $resultado['ID_senioridade'];
    }

    public function buscarPorId(int $id): ?SenioridadeEnum
    {
        $sql = 'SELECT senerioridade FROM tbl_senioridade WHERE ID_senioridade = ? LIMIT 1';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($resultado === false) {
            return null;
        }

        return SenioridadeEnum::tryFrom($resultado['senerioridade']) ?? null;
    }
}
