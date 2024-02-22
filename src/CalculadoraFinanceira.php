<?php

namespace src;

use Exception;

class CalculadoraFinanceira
{
    public function calcularJurosSimples($capital, $taxa, $tempo): string
    {
        try 
        {
            $this->validar($capital, $taxa, $tempo);

            return 'R$ ' . number_format(($capital * $taxa * 0.01 * $tempo), 2, ',', '.');
        } 
        catch (Exception $e) 
        {
            return $e->getMessage();
        }
    }

    public function calcularJurosCompostos($capital, $taxa, $tempo): string
    {
        try 
        {
            $this->validar($capital, $taxa, $tempo);

            return 'R$ ' . number_format($capital * (1 + $taxa * 0.01) ** $tempo, 2, ',', '.');
        } 
        catch (Exception $e) 
        {
            return $e->getMessage();
        }
    }

    public function calcularAmortizacao($capital, $taxa, $tempo, $tipo): array | string
    {
        try 
        {
            $this->validar($capital, $taxa, $tempo, $tipo);

            $juros     = array();
            $resultado = array();
            $taxa      = $taxa * 0.01;

            if ($tipo == "SAC") 
            {
                $amortizacao = number_format($capital / $tempo, 2, ',', '.');

                for ($i = 0; $i < $tempo; $i++) 
                {
                    $juros[$i]     = number_format($capital * $taxa - $capital / $tempo * $i * ($taxa) , 2, ',', '.');
                    $resultado[$i] = array( "Amortização" => 'R$ ' . $amortizacao,
                                            "Juros"       => 'R$ ' . $juros[$i]);
                }     
                return $resultado;
            }

            if ($tipo == "PRICE") 
            {
                $prestacao   = $capital * $taxa / (1 - (1 + $taxa) ** -$tempo);
                $amortizacao = array();

                for ($i = 0; $i < $tempo; $i++) 
                {
                    $juros[$i]       = $capital * $taxa - $prestacao;
                    $amortizacao[$i] = $prestacao - $juros[$i];

                    $resultado[$i]   = array( "Amortização" => 'R$ ' . number_format($amortizacao[$i], 2, ',', '.'),
                                              "Juros"       => 'R$ ' . number_format($juros[$i], 2, ',', '.'));
                }     
                return $resultado;
            }
        } 
        catch (Exception $e) 
        {
            return $e->getMessage();
        }
    }

    private function validar($capital, $taxa, $tempo, $tipo = "SAC")
    {
        if ($capital < 0) 
        {
            throw new Exception("O capital deve ser positivo");
        }

        if ($taxa < 0) 
        {
            throw new Exception("A taxa deve ser positiva");
        }

        if ($tempo < 0) 
        {
            throw new Exception("O tempo deve ser positivo");
        }

        if (!is_numeric($capital) || !is_numeric($taxa) || !is_numeric($tempo) || !is_string($tipo))
        {
            throw new Exception("Argumento(s) invalido(s)");
        }

        if ($tipo != "SAC" && $tipo != "PRICE") 
        {
            throw new Exception("Tipo inválido, escolha entre 'SAC' ou 'PRICE'");
        }

    }
}
