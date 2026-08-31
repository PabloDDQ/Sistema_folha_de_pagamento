<?php

namespace App\DAO;

use App\Conexao;
use App\Model\Colaborador;

class ColaboradorDAO
{
	public function create(Colaborador $colaborador)
	{
		$sql = 'INSERT INTO tbl_colaboradores (nome_colaborador, cargo_especifico,departamento_ID, senioridade_ID) VALUES (?,?,?,?)';
		$stmt = Conexao::getConn()->prepare($sql);
		$stmt->bindValue(1, $colaborador->getNomeColaborador());
		$stmt->bindValue(2, $colaborador->getCargoEspecifico());
		$stmt->bindValue(3, $colaborador->getDepartamento()->getId());
		$stmt->bindValue(4, $colaborador->getSenioridade()->value);
		$stmt->execute();
	}
	public function read()
	{
		$sql = 'SELECT * FROM tbl_colaboradores';
		$stmt = Conexao::getConn()->prepare($sql);
		$stmt->execute();

		if ($stmt->rowCount() > 0):
			$resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $resultado;
		else:
			return [];
		endif;
	}
	public function update(Colaborador $colaborador)
	{
		$sql = 'UPDATE tbl_colaboradores SET nome_colaborador = ?, cargo_especifico = ?, departamento_ID = ?, senioridade_ID = ? WHERE ID_colaboradores = ?';
		$stmt = Conexao::getConn()->prepare($sql);
		$stmt->bindValue(1, $colaborador->getNomeColaborador());
		$stmt->bindValue(2, $colaborador->getCargoEspecifico());
		$stmt->bindValue(3, $colaborador->getDepartamento()->getId());
		$stmt->bindValue(4, $colaborador->getSenioridade()->value);
		$stmt->bindValue(5, $colaborador->getId());
		$stmt->execute();
	}
	public function delete($id)
	{
		$sql = 'DELETE FROM tbl_colaboradores WHERE ID_colaboradores = ?';
		$stmt = Conexao::getConn()->prepare($sql);
		$stmt->bindValue(1, $id);
		$stmt->execute();
	}
}
