<?php
class Departamento
{
    private ?int $id = null;
    private string $nome_departamento;

    public function __construct(string $nome_departamento)
    {
        $this->nome_departamento = $nome_departamento;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNomeDepartamento(): string
    {
        return $this->nome_departamento;
    }

    public function setNomeDepartamento(string $nome_departamento): void
    {
        $this->nome_departamento = $nome_departamento;
    }
}
