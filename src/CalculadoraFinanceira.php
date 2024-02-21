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
        $this->taxa    = $taxa * 0.01;
        $this->tempo   = $tempo;
    }

    public function calcularJurosSimples(): string
    {
        return 'R$ ' . number_format($this->capital * $this->taxa * $this->tempo, 2, ',', '.');
    }

    public function calcularJurosCompostos(): string
    {
        return 'R$ ' . number_format($this->capital * (1 + $this->taxa) ** $this->tempo, 2, ',', '.');
    }

    public function calcularAmortizacao(string $tipo): array
    {
        try {
            $tipo = strtoupper($tipo);

            if ($tipo != "SAC" && $tipo != "PRICE") {
                throw new Exception("Tipo inválido, escolha entre 'SAC' ou 'PRICE' ");
            }

            if ($tipo == "SAC") {
                $amortizacao = number_format($this->capital / $this->tempo, 2, ',', '.');
                $juros       = array();
                $resultado   = array();

                for ($i = 0; $i < $this->tempo; $i++) 
                {
                    $juros[$i]     = number_format($this->capital * $this->taxa - $this->capital / $this->tempo * $i * ($this->taxa) , 2, ',', '.');
                    $resultado[$i] = array( "Amortização" => 'R$ ' . $amortizacao,
                                            "Juros"       => 'R$ ' . $juros[$i]);
                }     

                return $resultado;
            }

            if ($tipo == "PRICE") {
                // sei que é errado alocar memória novamente, mas para melhorar a leitura do código e facilitar o meu entendimento deixei assim.
                $tx          = $this->taxa;
                $tp          = $this->tempo;
                $ca          = $this->capital;
                $prestação   = $ca * ($tx * (1 + $tx) ** $tp) / ((1 + $tx) ** $tp - 1);
                $amortizacao = array();
                $juros       = array();
                $resultado   = array();

                for ($i = 0; $i < $this->tempo; $i++) 
                {

                    $juros[$i]       = number_format($this->capital * $this->taxa - $this->capital / $this->tempo * $i * ($this->taxa) , 2, ',', '.');

                    $resultado[$i]   = array( "Amortização" => 'R$ ' . $amortizacao[$i],
                                              "Juros"       => 'R$ ' . $juros[$i]);
                }     


                return $resultado;
            }
        } 
        catch (Exception $e) 
        {
            echo $e->getMessage();
        }
    }
}
