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
        $esperado2   = 'R$ 63.000.000.000,00';
        $esperado3   = 'R$ 0,00';

        $resultado   = $calculadora->calcularJurosSimples(350, 15, 5);
        $resultado2  = $calculadora->calcularJurosSimples(1000000000, 700, 9);
        $resultado3  = $calculadora->calcularJurosSimples(0, 2, 2);

        $this->assertSame($esperado, $resultado,   "erro no juros simples");
        $this->assertSame($esperado2, $resultado2, "erro no juros simples limite alto");
        $this->assertSame($esperado3, $resultado3, "erro no juros simples limite baixo");
    }

    public function testCalcularJurosSimplesComValoresNegativos()
    {
        $calculadora  = new CalculadoraFinanceira();
        $esperado1    = 'O capital deve ser positivo';
        $esperado2    = 'A taxa deve ser positiva';
        $esperado3    = 'O tempo deve ser positivo';

        $resultado1   = $calculadora->calcularJurosSimples(-350,  15,  5);
        $resultado2   = $calculadora->calcularJurosSimples(350, -15,  5);
        $resultado3   = $calculadora->calcularJurosSimples(350,  15, -5);

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
        $esperado2   = 'R$ 134.217.728.000.000.000,00';
        $esperado3   = 'R$ 0,00';


        $resultado   = $calculadora->calcularJurosCompostos(350, 15, 5);
        $resultado2  = $calculadora->CalcularJurosCompostos(1000000000, 700, 9);
        $resultado3  = $calculadora->CalcularJurosCompostos(0, 2, 2);


        $this->assertEquals($esperado,  $resultado,  "erro no juros compostos");
        $this->assertEquals($esperado2, $resultado2, "erro no juros compostos limite alto");
        $this->assertEquals($esperado3, $resultado3, "erro no juros compostos limite baixo");
    }

    public function testCalcularJurosCompostosComValoresNegativos()
    {
        $calculadora  = new CalculadoraFinanceira();
        $esperado1    = 'O capital deve ser positivo';
        $esperado2    = 'A taxa deve ser positiva';
        $esperado3    = 'O tempo deve ser positivo';

        $resultado1   = $calculadora->calcularJurosCompostos(-350,  15,  5);
        $resultado2   = $calculadora->calcularJurosCompostos(350, -15,  5);
        $resultado3   = $calculadora->calcularJurosCompostos(350,  15, -5);

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
        $esperado     = [
            ['Parcela' => 1, 'Valor' => 'R$ 5.175,00',  'Amortização' => 'R$ 5.000,00',  'Juros' => 'R$ 175,00', 'Devedor' => 'R$ 20.000,00'],
            ['Parcela' => 2, 'Valor' => 'R$ 5.140,00',  'Amortização' => 'R$ 5.000,00',  'Juros' => 'R$ 140,00', 'Devedor' => 'R$ 15.000,00'],
            ['Parcela' => 3, 'Valor' => 'R$ 5.105,00',  'Amortização' => 'R$ 5.000,00',  'Juros' => 'R$ 105,00', 'Devedor' => 'R$ 10.000,00'],
            ['Parcela' => 4, 'Valor' => 'R$ 5.070,00',  'Amortização' => 'R$ 5.000,00',  'Juros' => 'R$ 70,00',  'Devedor' => 'R$ 5.000,00'],
            ['Parcela' => 5, 'Valor' => 'R$ 5.035,00',  'Amortização' => 'R$ 5.000,00',  'Juros' => 'R$ 35,00',  'Devedor' => 'R$ 0,00'],
            'Total'   =>   ['Valor' => 'R$ 25.525,00', 'Amortização' => 'R$ 25.000,00', 'Juros' => 'R$ 525,00']
        ];

        $esperado2    = [
            ['Parcela' => 1, 'Valor' => 'R$ 33.083.333,33',  'Amortização' => 'R$ 8.333.333,33',  'Juros' => 'R$ 24.750.000,00', 'Devedor' => 'R$ 16.666.666,67'],
            ['Parcela' => 2, 'Valor' => 'R$ 24.833.333,33',  'Amortização' => 'R$ 8.333.333,33',  'Juros' => 'R$ 16.500.000,00', 'Devedor' => 'R$ 8.333.333,33'],
            ['Parcela' => 3, 'Valor' => 'R$ 16.583.333,33',  'Amortização' => 'R$ 8.333.333,33',  'Juros' => 'R$ 8.250.000,00', 'Devedor' => 'R$ 0,00'],
            'Total'   =>   ['Valor' => 'R$ 74.500.000,00', 'Amortização' => 'R$ 25.000.000,00', 'Juros' => 'R$ 49.500.000,00']
        ];

        $esperado3   =  []

        $resultado     = $calculadora->calcularAmortizacao(25000.00, 0.7, 5, "SAC");
        $resultado2    = $calculadora->calcularAmortizacao(25000000.00, 99, 3, "SAC");
        $resultado3    = $calculadora->calcularAmortizacao(1, 1, 1, "SAC");

        assertEquals($esperado, $resultado, "erro no SAC");
        assertEquals($esperado2, $resultado2, "erro no SAC com valores altos");
    }

    public function testCalcularAmortizacaoComValoresNegativos()
    {
        $calculadora  = new CalculadoraFinanceira();
        $esperado1    = 'O capital deve ser positivo';
        $esperado2    = 'A taxa deve ser positiva';
        $esperado3    = 'O tempo deve ser positivo';

        $resultado1   = $calculadora->calcularAmortizacao(-25000.00,  0.7,  5, "SAC");
        $resultado2   = $calculadora->calcularAmortizacao(25000.00, -0.7,  5, "SAC");
        $resultado3   = $calculadora->calcularAmortizacao(25000.00,  0.7, -5, "SAC");

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

    public function testCalcularAmortizacaoPrice()
    {
        $calculadora  = new CalculadoraFinanceira();
        $esperado     = [
            ['Parcela' => 1, 'Valor' => 'R$ 5.105,49',  'Amortização' => 'R$ 4.930,49',  'Juros' => 'R$ 175,00', 'Devedor' => 'R$ 20.069,51'],
            ['Parcela' => 2, 'Valor' => 'R$ 5.105,49',  'Amortização' => 'R$ 4.965,00',  'Juros' => 'R$ 140,49', 'Devedor' => 'R$ 15.104,51'],
            ['Parcela' => 3, 'Valor' => 'R$ 5.105,49',  'Amortização' => 'R$ 4.999,76',  'Juros' => 'R$ 105,73', 'Devedor' => 'R$ 10.104,75'],
            ['Parcela' => 4, 'Valor' => 'R$ 5.105,49',  'Amortização' => 'R$ 5.034,76',  'Juros' => 'R$ 70,73',  'Devedor' => 'R$ 5.070,00'],
            ['Parcela' => 5, 'Valor' => 'R$ 5.105,49',  'Amortização' => 'R$ 5.070,00',  'Juros' => 'R$ 35,49',  'Devedor' => 'R$ 0,00'],
            // 'Total'   =>    ['Valor' => 'R$ 25.527,45', 'Amortização' => 'R$ 25.000,00', 'Juros' => 'R$ 527,45']
        ];

        $resultado     = $calculadora->calcularAmortizacao(25000.00, 0.7, 5, "PRICE");

        assertEquals($esperado, $resultado, "erro no PRICE 1");
    }
}
