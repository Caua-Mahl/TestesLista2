<?php 

use PHPUnit\Framework\TestCase;
use src\CalculadoraFinanceira;

require_once 'src/CalculadoraFinanceira.php';

class CalculadoraFinanceiraTest extends TestCase
{
    public function testCalcularJurosSimples()
    {
        $calculadora = new CalculadoraFinanceira(350, 15, 5);
        $this->assertSame('R$ 262,50', $calculadora->calcularJurosSimples());
    }

    public function testCalcularJurosCompostos()
    {
        $calculadora = new CalculadoraFinanceira(350, 15, 5);
        $this->assertEquals('R$ 703,98', $calculadora->calcularJurosCompostos());
    }

    public function testCalcularAmortizacao()
    {
        $calculadora = new CalculadoraFinanceira(250000.00, 0.7, 200);
        $this->assertEquals(array("Amortização" => 'R$ 1.250,00', 
                                  "Juros"       => 'R$ 175,00'),
                                $calculadora->calcularAmortizacao("SAC"),   "erro no SAC");

        $this->assertEquals(array("Amortização" => 'R$ 576,52', 
                                  "Juros"       => 'R$ 175,00'),
                                $calculadora->calcularAmortizacao("PRICE"), "erro no PRICE");
    }
}