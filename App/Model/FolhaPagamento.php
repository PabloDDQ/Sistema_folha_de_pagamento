<?php
class FolhaPagamento
{
    private ?int $id = null;
    private Colaborador $colaborador;
    private int $dias_trabalhados;
    private float $extra;
    private float $total_pagamento;
    private DateTimeInterface $dia_lancamento_pagamento;

    public function __construct(
        Colaborador $colaborador,
        int $dias_trabalhados,
        float $extra,
        float $total_pagamento,
        DateTimeInterface $dia_lancamento_pagamento
    ) {
        $this->colaborador = $colaborador;
        $this->dias_trabalhados = $dias_trabalhados;
        $this->extra = $extra;
        $this->total_pagamento = $total_pagamento;
        $this->dia_lancamento_pagamento = $dia_lancamento_pagamento;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getColaborador(): Colaborador
    {
        return $this->colaborador;
    }

    public function setColaborador(Colaborador $colaborador): void
    {
        $this->colaborador = $colaborador;
    }

    public function getDiasTrabalhados(): int
    {
        return $this->dias_trabalhados;
    }

    public function setDiasTrabalhados(int $dias_trabalhados): void
    {
        $this->dias_trabalhados = $dias_trabalhados;
    }

    public function getExtra(): float
    {
        return $this->extra;
    }

    public function setExtra(float $extra): void
    {
        $this->extra = $extra;
    }

    public function getTotalPagamento(): float
    {
        return $this->total_pagamento;
    }

    public function setTotalPagamento(float $total_pagamento): void
    {
        $this->total_pagamento = $total_pagamento;
    }

    public function getDiaLancamentoPagamento(): DateTimeInterface
    {
        return $this->dia_lancamento_pagamento;
    }

    public function setDiaLancamentoPagamento(DateTimeInterface $dia_lancamento_pagamento): void
    {
        $this->dia_lancamento_pagamento = $dia_lancamento_pagamento;
    }
}
