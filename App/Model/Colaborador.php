<?php
namespace App\Model;
class Colaborador
{
    private ?int $id = null;
    private string $nome_colaborador;
    private string $cargo_especifico;
    private Departamento $departamento;
    private SenioridadeEnum $senioridade;

    public function __construct(string $nome_colaborador, string $cargo_especifico, Departamento $departamento, SenioridadeEnum $senioridade)
    {
        $this->nome_colaborador = $nome_colaborador;
        $this->cargo_especifico = $cargo_especifico;
        $this->departamento = $departamento;
        $this->senioridade = $senioridade;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNomeColaborador(): string
    {
        return $this->nome_colaborador;
    }

    public function setNomeColaborador(string $nome_colaborador): void
    {
        $this->nome_colaborador = $nome_colaborador;
    }

    public function getCargoEspecifico(): string
    {
        return $this->cargo_especifico;
    }

    public function setCargoEspecifico(string $cargo_especifico): void
    {
        $this->cargo_especifico = $cargo_especifico;
    }

    public function getDepartamento(): Departamento
    {
        return $this->departamento;
    }

    public function setDepartamento(Departamento $departamento): void
    {
        $this->departamento = $departamento;
    }

    public function getSenioridade(): SenioridadeEnum
    {
        return $this->senioridade;
    }

    public function setSenioridade(SenioridadeEnum $senioridade): void
    {
        $this->senioridade = $senioridade;
    }
}
