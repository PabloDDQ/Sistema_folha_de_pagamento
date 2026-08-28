<?php

enum SenioridadeEnum: string
{
    case Estagiario = 'estagiario';
    case Junior = 'junior';
    case Pleno = 'pleno';
    case Senior = 'senior';
    case Especialista = 'especialista';
    case Gerente = 'gerente';
    case Diretor = 'diretor';

    public function salario(): int
    {
        return match ($this) {
            self::Estagiario => 1500,
            self::Junior => 3500,
            self::Pleno => 6000,
            self::Senior => 10000,
            self::Especialista => 13000,
            self::Gerente => 15000,
            self::Diretor => 22000,
        };
    }
}
