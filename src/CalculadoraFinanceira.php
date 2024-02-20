<?php

class CalculadoraFinanceira
{
    public function calcularJurosSimples(float $capital, int $taxa, int $tempo): float
    {
        return $jurosSimples = 0.0;
    }

    public function calcularJurosCompostos(float $capital, int $taxa, int $tempo, string $tipo): float
    {
        return $jurosCompostos = 0.0;
    }

    public function calcularAmortizacao(float $capital, int $taxa, int $tempo, string $tipo):array
    {
        return $amortizacao=[];
    }
}
