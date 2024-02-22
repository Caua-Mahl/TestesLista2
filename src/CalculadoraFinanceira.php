<?php

namespace src;

use Exception;

class CalculadoraFinanceira
{
    public function calcularJurosSimples($capital, $taxa, $tempo): string
    {
        try {
            $this->validar($capital, $taxa, $tempo);

            return 'R$ ' . number_format(($capital * $taxa * 0.01 * $tempo), 2, ',', '.');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function calcularJurosCompostos($capital, $taxa, $tempo): string
    {
        try {
            $this->validar($capital, $taxa, $tempo);

            return 'R$ ' . number_format($capital * (1 + $taxa * 0.01) ** $tempo, 2, ',', '.');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function calcularAmortizacao($capital, $taxa, $tempo, $tipo): array | string
    {
        try {
            $this->validar($capital, $taxa, $tempo, $tipo);

            $taxa = $taxa * 0.01;

            if ($tipo == "SAC") {
                $amortizacao = $capital / $tempo;

                for ($i = 0; $i < $tempo; $i++) {
                    $juros[$i]        = $capital     * $taxa        - $capital / $tempo * $i * ($taxa);
                    $devedor[$i]      = $capital     - $amortizacao * ($i + 1);
                    $valorParcela[$i] = $amortizacao + $juros[$i];
                    $resultado[$i]    = [
                        "Parcela"     => $i + 1,
                        "Valor"       => 'R$ ' . number_format($valorParcela[$i], 2, ',', '.'),
                        "Amortização" => 'R$ ' . number_format($amortizacao,      2, ',', '.'),
                        "Juros"       => 'R$ ' . number_format($juros[$i],        2, ',', '.'),
                        "Devedor"     => 'R$ ' . number_format($devedor[$i],      2, ',', '.')
                    ];
                }

                $resultado["Total"]   = [
                    "Valor"       => 'R$ ' . number_format(array_sum($valorParcela), 2, ',', '.'),
                    "Amortização" => 'R$ ' . number_format($capital, 2, ',', '.'),
                    "Juros"       => 'R$ ' . number_format(array_sum($juros), 2, ',', '.')
                ];

                return $resultado;
            }

            //A fórmula é: P = (PV * i) / (1 – (1 + i)^-n), onde: P é a parcela, PV é o valor principal, i é a taxa de juros e.
            if ($tipo == "PRICE") {

                $devedor[0] = $capital;

                for ($i = 0; $i < $tempo; $i++) {
                    $valorParcela  = ($capital * $taxa) / (1 - (1 + $taxa) ** -$tempo);
                    $juros[$i] = $devedor[$i] * $taxa;
                    $amortizacao[$i] = $valorParcela - $juros[$i];
                    $devedor[$i] = $capital - $amortizacao[$i];
                    $devedor[$i+1] = $capital - $amortizacao[$i];
                    $resultado[$i]   =  [
                        "Parcela"     => $i + 1,
                        "Valor"       => 'R$ ' . number_format($valorParcela, 2, ',', '.'),
                        "Amortização" => 'R$ ' . number_format($amortizacao[$i],      2, ',', '.'),
                        "Juros"       => 'R$ ' . number_format($juros[$i],        2, ',', '.'),
                        "Devedor"     => 'R$ ' . number_format($devedor[$i],      2, ',', '.')
                    ];
                }
                /*
                $resultado["Total"]   = [
                    "Valor"       => 'R$ ' . number_format(array_sum($valorParcela), 2, ',', '.'),
                    "Amortização" => 'R$ ' . number_format($capital, 2, ',', '.'),
                    "Juros"       => 'R$ ' . number_format(array_sum($juros), 2, ',', '.')
                ]; */
                return $resultado;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    private function validar($capital, $taxa, $tempo, $tipo = "SAC")
    {
        if ($capital < 0) {
            throw new Exception("O capital deve ser positivo");
        }

        if ($taxa < 0) {
            throw new Exception("A taxa deve ser positiva");
        }

        if ($tempo < 0) {
            throw new Exception("O tempo deve ser positivo");
        }

        if (!is_numeric($capital) || !is_numeric($taxa) || !is_numeric($tempo) || !is_string($tipo)) {
            throw new Exception("Argumento(s) invalido(s)");
        }

        if ($tipo != "SAC" && $tipo != "PRICE") {
            throw new Exception("Tipo inválido, escolha entre 'SAC' ou 'PRICE'");
        }
    }
}
