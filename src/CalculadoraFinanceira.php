<?php

namespace src;

use Exception;

class CalculadoraFinanceira
{

    private float $capital;
    private float $taxa;
    private int   $tempo;

    public function __construct(float $capital, float $taxa, int $tempo)
    {
        $this->capital = $capital;
        $this->taxa    = $taxa;
        $this->tempo   = $tempo;
    }

    public function calcularJurosSimples(): float
    {
        return $this->capital * $this->taxa * $this->tempo;
    }

    public function calcularJurosCompostos(): float
    {
        return $this->capital * (1 + $this->taxa) ** $this->tempo;
    }

    public function calcularAmortizacao(string $tipo):array
    {
        try 
        {
            $tipo = strtoupper($tipo);
            
            if ($tipo != "SAC" && $tipo != "PRICE")
            {
                throw new Exception("Tipo inválido, escolha entre 'SAC' ou 'PRICE' ");
            }

            if ($tipo == "SAC")
            {
                $amortizacao = $this->capital / $this->tempo;
                $juros       = $this->capital * $this->taxa * 0.1;

                return array("Amortização" => $amortizacao, "Juros" => $juros);
            }

            if ($tipo == "PRICE")
            {
                // sei que é errado alocar memória novamente, mas para melhorar a leitura do código e facilitar o meu entendimento deixei assim.
                $tx          = $this->taxa;
                $tp          = $this->tempo;
                $ca          = $this->capital;
                $juros       = $ca * $tx;
                $prestacao   = $ca * ($tx / (1 - (1 + $tx) ** -$tp));
                $amortizacao = $prestacao - $juros;


                return array("Amortização" => $amortizacao, "Juros" => $juros * 0.1);
            }

        } 
        catch (Exception $e) 
        {
            echo $e->getMessage();
        }
    }
}
