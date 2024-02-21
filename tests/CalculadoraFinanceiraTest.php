<?php

use PHPUnit\Framework\TestCase;
use src\CalculadoraFinanceira;

use function PHPUnit\Framework\assertEquals;

require_once 'src/CalculadoraFinanceira.php';

class CalculadoraFinanceiraTest extends TestCase
{
    public function testCalcularJurosSimples()
    {
        $calculadora = new CalculadoraFinanceira(350, 15, 5);
        $esperado    = 'R$ 262,50';

        $resultado   = $calculadora->calcularJurosSimples();

        $this->assertSame($esperado, $resultado);
    }

    public function testCalcularJurosCompostos()
    {
        $calculadora = new CalculadoraFinanceira(350, 15, 5);
        $this->assertEquals('R$ 703,98', $calculadora->calcularJurosCompostos());
    }

    public function testCalcularAmortizacaoSAC()
    {
        $calculadora   = new CalculadoraFinanceira(25000.00, 0.7, 5);
        $resultado     = $calculadora->calcularAmortizacao("SAC");

        $esperado      = array(
                                array('Amortização' => 'R$ 5.000,00', 'Juros' => 'R$ 175,00'),
                                array('Amortização' => 'R$ 5.000,00', 'Juros' => 'R$ 140,00'),
                                array('Amortização' => 'R$ 5.000,00', 'Juros' => 'R$ 105,00'),
                                array('Amortização' => 'R$ 5.000,00', 'Juros' => 'R$ 70,00'),
                                array('Amortização' => 'R$ 5.000,00', 'Juros' => 'R$ 35,00')
                            );

        assertEquals($esperado, $resultado, "erro no SAC 1");
    }

    public function testCalcularAmortizacaoPrice()
    {
        $calculadora   = new CalculadoraFinanceira(25000.00, 0.7, 5);
        $resultado     = $calculadora->calcularAmortizacao("PRICE");

        $esperado      = array(
                                array('Amortização' => 'R$ 4.930,49', 'Juros' => 'R$ 175,00'),
                                array('Amortização' => 'R$ 4.965,00', 'Juros' => 'R$ 140,49'),
                                array('Amortização' => 'R$ 4.999,76', 'Juros' => 'R$ 105,73'),
                                array('Amortização' => 'R$ 5.034,76', 'Juros' => 'R$ 70,73'),
                                array('Amortização' => 'R$ 5.070,00', 'Juros' => 'R$ 35,49')
                            );

        assertEquals($esperado, $resultado, "erro no PRICE 1");
    }






    /*
        $this->assertEquals(array("Amortização" => 'R$ 1.250,00', 
                                  "Juros"       => 'R$ 175,00'),
                                $calculadora->calcularAmortizacao("SAC"),   "erro no SAC");

        $this->assertEquals(array("Amortização" => 'R$ 576,52', 
                                  "Juros"       => 'R$ 175,00'),
                                $calculadora->calcularAmortizacao("PRICE"), "erro no PRICE");
        */
}
