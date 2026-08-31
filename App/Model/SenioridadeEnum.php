<?php

namespace App\Model;
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

    public function id(): int
    {
        return match ($this) {
            self::Estagiario => 1,
            self::Junior => 2,
            self::Pleno => 3,
            self::Senior => 4,
            self::Especialista => 5,
            self::Gerente => 6,
            self::Diretor => 7,
        };
    }

    public static function fromId(int $id): self
    {
        return match ($id) {
            1 => self::Estagiario,
            2 => self::Junior,
            3 => self::Pleno,
            4 => self::Senior,
            5 => self::Especialista,
            6 => self::Gerente,
            7 => self::Diretor,
            default => throw new \InvalidArgumentException('Senioridade inválida.'),
        };
    }
}
