<?php 

use PHPUnit\Framework\TestCase;
use src\CalculadoraFinanceira;

require_once 'src/CalculadoraFinanceira.php';

class CalculadoraFinanceiraTest extends TestCase
{
    public function testCalcularJurosSimples()
    {
        $calculadora = new CalculadoraFinanceira(350.50, 0.15, 5);
        $this->assertEquals(262.50, $calculadora->calcularJurosSimples());
    }

    public function testCalcularJurosCompostos()
    {
        $calculadora = new CalculadoraFinanceira(350.50, 0.15, 5);
        $this->assertEquals(703.97, $calculadora->calcularJurosCompostos());
    }

    public function testCalcularAmortizacao()
    {
        $calculadora = new CalculadoraFinanceira(250000.00, 0.007, 200);
        $this->assertEquals(array("Amortização" => 1250.00, "Juros" => 175.00), $calculadora->calcularAmortizacao("SAC"),    "erro no SAC");
        $this->assertEquals(array("Amortização" =>  576.52 , "Juros" => 175.00), $calculadora->calcularAmortizacao("PRICE"), "erro no PRICE");
    }
}