<?php

namespace App\DAO;

use App\Conexao;
use App\Model\Departamento;

class DepartamentoDAO
{
    public function create(Departamento $departamento)
    {
        $sql = 'INSERT INTO tbl_departamento (nome_departamento) VALUES (?)';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->bindValue(1, $departamento->getNomeDepartamento());
        $stmt->execute();
    }
    public function read()
    {
        $sql = 'SELECT * FROM tbl_departamento';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0):
            $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        else:
            return [];
        endif;
    }
    public function update(Departamento $departamento)
    {
        $sql = 'UPDATE tbl_departamento SET nome_departamento = ? WHERE ID_departamento = ?';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->bindValue(1, $departamento->getNomeDepartamento());
        $stmt->bindValue(2, $departamento->getId());
        $stmt->execute();
    }
    public function delete($id)
    {
        $sql = 'DELETE FROM tbl_departamento WHERE ID_departamento = ?';
        $stmt = Conexao::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
}
