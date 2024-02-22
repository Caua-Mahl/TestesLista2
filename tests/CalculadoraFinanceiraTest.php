<?php

use PHPUnit\Framework\MockObject\Generator\MockClass;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;
use src\CalculadoraFinanceira;

use function PHPUnit\Framework\assertEquals;

require_once 'src/CalculadoraFinanceira.php';

class CalculadoraFinanceiraTest extends TestCase
{
    public function testCalcularJurosSimples()
    {
        $calculadora = new CalculadoraFinanceira();
        $esperado    = 'R$ 262,50';

        $resultado   = $calculadora->calcularJurosSimples(350, 15, 5);

        $this->assertSame($esperado, $resultado);
    }

    public function testCalcularJurosSimplesComValoresNegativos()
    {
        $calculadora  = new CalculadoraFinanceira();
        $esperado1    = 'O capital deve ser positivo';
        $esperado2    = 'A taxa deve ser positiva';
        $esperado3    = 'O tempo deve ser positivo';

        $resultado1   = $calculadora->calcularJurosSimples(-350,  15,  5);
        $resultado2   = $calculadora->calcularJurosSimples( 350, -15,  5);
        $resultado3   = $calculadora->calcularJurosSimples( 350,  15, -5);

        $this->assertEquals($esperado1, $resultado1, "erro ao testar capital negativo");
        $this->assertEquals($esperado2, $resultado2, "erro ao testar taxa negativa");
        $this->assertEquals($esperado3, $resultado3, "erro ao testar tempo negativo");
    }

    public function testCalcularJurosSimplesComValoresInvalidos()
    {
        $calculadora = new CalculadoraFinanceira();
        $esperado    = 'Argumento(s) invalido(s)';

        $resultado   = $calculadora->calcularJurosSimples("a", null, []);

        $this->assertEquals($esperado, $resultado);
    }
    public function testCalcularJurosCompostos()
    {
        $calculadora = new CalculadoraFinanceira();
        $esperado    = 'R$ 703,98';

        $resultado   = $calculadora->calcularJurosCompostos(350, 15, 5);

        $this->assertEquals($esperado, $resultado);
    }

    public function testCalcularJurosCompostosComValoresNegativos()
    {
        $calculadora  = new CalculadoraFinanceira();
        $esperado1    = 'O capital deve ser positivo';
        $esperado2    = 'A taxa deve ser positiva';
        $esperado3    = 'O tempo deve ser positivo';

        $resultado1   = $calculadora->calcularJurosCompostos(-350,  15,  5);
        $resultado2   = $calculadora->calcularJurosCompostos( 350, -15,  5);
        $resultado3   = $calculadora->calcularJurosCompostos( 350,  15, -5);

        $this->assertEquals($esperado1, $resultado1, "erro ao testar capital negativo");
        $this->assertEquals($esperado2, $resultado2, "erro ao testar taxa negativa");
        $this->assertEquals($esperado3, $resultado3, "erro ao testar tempo negativo");
    } 

    public function testCalcularJurosCompostosComValoresInvalidos()
    {
        $calculadora = new CalculadoraFinanceira();
        $esperado    = 'Argumento(s) invalido(s)';

        $resultado   = $calculadora->calcularJurosCompostos("a", null, []);

        $this->assertEquals($esperado, $resultado);
    }

    public function testCalcularAmortizacaoSAC()
    {
        $calculadora  = new CalculadoraFinanceira();
        $esperado     = array(
                               array('Amortização' => 'R$ 5.000,00', 'Juros' => 'R$ 175,00'),
                               array('Amortização' => 'R$ 5.000,00', 'Juros' => 'R$ 140,00'),
                               array('Amortização' => 'R$ 5.000,00', 'Juros' => 'R$ 105,00'),
                               array('Amortização' => 'R$ 5.000,00', 'Juros' => 'R$ 70,00'),
                               array('Amortização' => 'R$ 5.000,00', 'Juros' => 'R$ 35,00')
                            );

        $resultado     = $calculadora->calcularAmortizacao(25000.00, 0.7, 5, "SAC");

        assertEquals($esperado, $resultado, "erro no SAC 1");       

    }

    public function testCalcularAmortizacaoComValoresNegativos()
    {
        $calculadora  = new CalculadoraFinanceira();
        $esperado1    = 'O capital deve ser positivo';
        $esperado2    = 'A taxa deve ser positiva';
        $esperado3    = 'O tempo deve ser positivo';

        $resultado1   = $calculadora->calcularAmortizacao(-25000.00,  0.7,  5, "SAC");
        $resultado2   = $calculadora->calcularAmortizacao( 25000.00, -0.7,  5, "SAC");
        $resultado3   = $calculadora->calcularAmortizacao( 25000.00,  0.7, -5, "SAC");

        $this->assertEquals($esperado1, $resultado1, "erro ao testar capital negativo");
        $this->assertEquals($esperado2, $resultado2, "erro ao testar taxa negativa");
        $this->assertEquals($esperado3, $resultado3, "erro ao testar tempo negativo");
    }

    public function testCalcularAmortizacaoComTipoErrado()
    {
        $calculadora = new CalculadoraFinanceira();
        $esperado    = "Tipo inválido, escolha entre 'SAC' ou 'PRICE'";

        $resultado   = $calculadora->calcularAmortizacao(25000.00, 0.7, 5, "SACRE");

        $this->assertEquals($esperado, $resultado);
    }

    public function testCalcularAmortizacaoComValoresInvalidos()
    {
        $calculadora = new CalculadoraFinanceira();
        $esperado    = 'Argumento(s) invalido(s)';

        $resultado   = $calculadora->calcularAmortizacao("a", null, [], 1);

        $this->assertEquals($esperado, $resultado);
    }

   /* public function testCalcularAmortizacaoPrice()
    {
        $calculadora   = new CalculadoraFinanceira();
        $esperado      = array(
                                array('Amortização' => 'R$ 4.930,49', 'Juros' => 'R$ 175,00'), 
                                array('Amortização' => 'R$ 4.965,00', 'Juros' => 'R$ 140,49'),
                                array('Amortização' => 'R$ 4.999,76', 'Juros' => 'R$ 105,73'),
                                array('Amortização' => 'R$ 5.034,76', 'Juros' => 'R$ 70,73'),
                                array('Amortização' => 'R$ 5.070,00', 'Juros' => 'R$ 35,49')  
                            );

        $resultado     = $calculadora->calcularAmortizacao(25000.00, 0.7, 5,"PRICE");
    
        assertEquals($esperado, $resultado, "erro no PRICE 1");
    }*/
}
