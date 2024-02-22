<?php

use PHPUnit\Framework\TestCase;
use src\CalculadoraFinanceira;

use function PHPUnit\Framework\assertEquals;

require_once 'src/CalculadoraFinanceira.php';

class CalculadoraFinanceiraTest extends TestCase
{
    private CalculadoraFinanceira $calculadora;

    public function setUp(): void
    {
        $this->calculadora = new CalculadoraFinanceira();
    }

    public function testCalcularJurosSimples()
    {
        $esperado1  = 'R$ 262,50';
        $esperado2  = 'R$ 63.000.000.000,00';
        $esperado3  = 'R$ 0,00';

        $resultado1 = $this->calculadora->calcularJurosSimples(350, 15, 5);
        $resultado2 = $this->calculadora->calcularJurosSimples(1000000000, 700, 9);
        $resultado3 = $this->calculadora->calcularJurosSimples(0, 2, 2);

        $this->assertEquals($esperado1, $resultado1, "erro no juros simples");
        $this->assertEquals($esperado2, $resultado2, "erro no juros simples limite alto");
        $this->assertEquals($esperado3, $resultado3, "erro no juros simples limite baixo");
    }

    public function testCalcularJurosSimplesComValoresNegativos()
    {
        $esperado1  = 'O capital deve ser positivo';
        $esperado2  = 'A taxa deve ser positiva';
        $esperado3  = 'O tempo deve ser positivo';

        $resultado1 = $this->calculadora->calcularJurosSimples(-350,  15,  5);
        $resultado2 = $this->calculadora->calcularJurosSimples(350, -15,  5);
        $resultado3 = $this->calculadora->calcularJurosSimples(350,  15, -5);

        $this->assertEquals($esperado1, $resultado1, "erro ao testar capital negativo");
        $this->assertEquals($esperado2, $resultado2, "erro ao testar taxa negativa");
        $this->assertEquals($esperado3, $resultado3, "erro ao testar tempo negativo");
    }

    public function testCalcularJurosSimplesComValoresInvalidos()
    {
        $esperado  = 'Argumento(s) invalido(s)';

        $resultado = $this->calculadora->calcularJurosSimples("a", null, []);
        
        $this->assertEquals($esperado, $resultado, "erro ao testar valores invalidos");
    }

    public function testCalcularJurosCompostos()
    {
        $esperado1  = 'R$ 703,98';
        $esperado2  = 'R$ 134.217.728.000.000.000,00';
        $esperado3  = 'R$ 0,00';

        $resultado1 = $this->calculadora->calcularJurosCompostos(350,         15, 5);
        $resultado2 = $this->calculadora->CalcularJurosCompostos(1000000000, 700, 9);
        $resultado3 = $this->calculadora->CalcularJurosCompostos(0,            2, 2);

        $this->assertEquals($esperado1, $resultado1, "erro no juros compostos");
        $this->assertEquals($esperado2, $resultado2, "erro no juros compostos limite alto");
        $this->assertEquals($esperado3, $resultado3, "erro no juros compostos limite baixo");
    }

    public function testCalcularJurosCompostosComValoresNegativos()
    {
        $esperado1  = 'O capital deve ser positivo';
        $esperado2  = 'A taxa deve ser positiva';
        $esperado3  = 'O tempo deve ser positivo';

        $resultado1 = $this->calculadora->calcularJurosCompostos(-350,  15,  5);
        $resultado2 = $this->calculadora->calcularJurosCompostos( 350, -15,  5);
        $resultado3 = $this->calculadora->calcularJurosCompostos( 350,  15, -5);

        $this->assertEquals($esperado1, $resultado1, "erro ao testar capital negativo");
        $this->assertEquals($esperado2, $resultado2, "erro ao testar taxa negativa");
        $this->assertEquals($esperado3, $resultado3, "erro ao testar tempo negativo");
    }

    public function testCalcularJurosCompostosComValoresInvalidos()
    {
        $esperado  = 'Argumento(s) invalido(s)';

        $resultado = $this->calculadora->calcularJurosCompostos("a", null, []);

        $this->assertEquals($esperado, $resultado, "erro ao testar valores invalidos");
    }

    public function testCalcularAmortizacaoSAC()
    {
        $esperado1  = [['Parcela' => 1, 'Valor' => 'R$ 5.175,00',  'Amortização' => 'R$ 5.000,00',  'Juros' => 'R$ 175,00', 'Devedor' => 'R$ 20.000,00'],
                       ['Parcela' => 2, 'Valor' => 'R$ 5.140,00',  'Amortização' => 'R$ 5.000,00',  'Juros' => 'R$ 140,00', 'Devedor' => 'R$ 15.000,00'],
                       ['Parcela' => 3, 'Valor' => 'R$ 5.105,00',  'Amortização' => 'R$ 5.000,00',  'Juros' => 'R$ 105,00', 'Devedor' => 'R$ 10.000,00'],
                       ['Parcela' => 4, 'Valor' => 'R$ 5.070,00',  'Amortização' => 'R$ 5.000,00',  'Juros' => 'R$ 70,00',  'Devedor' => 'R$ 5.000,00'],
                       ['Parcela' => 5, 'Valor' => 'R$ 5.035,00',  'Amortização' => 'R$ 5.000,00',  'Juros' => 'R$ 35,00',  'Devedor' => 'R$ 0,00'],
                        'Total'   =>   ['Valor' => 'R$ 25.525,00', 'Amortização' => 'R$ 25.000,00', 'Juros' => 'R$ 525,00']];

        $esperado2  = [['Parcela' => 1, 'Valor' => 'R$ 33.083.333,33',  'Amortização' => 'R$ 8.333.333,33',  'Juros' => 'R$ 24.750.000,00', 'Devedor' => 'R$ 16.666.666,67'],
                       ['Parcela' => 2, 'Valor' => 'R$ 24.833.333,33',  'Amortização' => 'R$ 8.333.333,33',  'Juros' => 'R$ 16.500.000,00', 'Devedor' => 'R$ 8.333.333,33'],
                       ['Parcela' => 3, 'Valor' => 'R$ 16.583.333,33',  'Amortização' => 'R$ 8.333.333,33',  'Juros' => 'R$ 8.250.000,00',  'Devedor' => 'R$ 0,00'],
                        'Total'   =>   ['Valor' => 'R$ 74.500.000,00',  'Amortização' => 'R$ 25.000.000,00', 'Juros' => 'R$ 49.500.000,00']];

        $esperado3  = [['Parcela' => 1, 'Valor' => 'R$ 0,35',  'Amortização' => 'R$ 0,33',  'Juros' => 'R$ 0,02', 'Devedor' => 'R$ 0,67'],
                       ['Parcela' => 2, 'Valor' => 'R$ 0,35',  'Amortização' => 'R$ 0,33',  'Juros' => 'R$ 0,01', 'Devedor' => 'R$ 0,33'],
                       ['Parcela' => 3, 'Valor' => 'R$ 0,34',  'Amortização' => 'R$ 0,33',  'Juros' => 'R$ 0,01', 'Devedor' => 'R$ 0,00'],
                        'Total'   =>   ['Valor' => 'R$ 1,04',  'Amortização' => 'R$ 1,00',  'Juros' => 'R$ 0,04']];
          
        $resultado1 = $this->calculadora->calcularAmortizacao(25000.00,   0.7, 5, "SAC");
        $resultado2 = $this->calculadora->calcularAmortizacao(25000000.00, 99, 3, "SAC");
        $resultado3 = $this->calculadora->calcularAmortizacao(1.00,         2, 3, "SAC");

        assertEquals($esperado1, $resultado1, "erro no SAC");
        assertEquals($esperado2, $resultado2, "erro no SAC com valores altos");
        assertEquals($esperado3, $resultado3, "erro no SAC com valores baixos");
    }

    public function testCalcularAmortizacaoPrice()
    {
        
        $esperado1  = [['Parcela' => 1, 'Valor' => 'R$ 5.105,49',  'Amortização' => 'R$ 4.930,49',  'Juros' => 'R$ 175,00', 'Devedor' => 'R$ 20.069,51'],
                       ['Parcela' => 2, 'Valor' => 'R$ 5.105,49',  'Amortização' => 'R$ 4.965,00',  'Juros' => 'R$ 140,49', 'Devedor' => 'R$ 15.104,51'],
                       ['Parcela' => 3, 'Valor' => 'R$ 5.105,49',  'Amortização' => 'R$ 4.999,76',  'Juros' => 'R$ 105,73', 'Devedor' => 'R$ 10.104,75'],
                       ['Parcela' => 4, 'Valor' => 'R$ 5.105,49',  'Amortização' => 'R$ 5.034,76',  'Juros' => 'R$ 70,73',  'Devedor' => 'R$ 5.070,00'],
                       ['Parcela' => 5, 'Valor' => 'R$ 5.105,49',  'Amortização' => 'R$ 5.070,00',  'Juros' => 'R$ 35,49',  'Devedor' => 'R$ 0,00'],
                        'Total'   =>   ['Valor' => 'R$ 25.527,44', 'Amortização' => 'R$ 25.000,00', 'Juros' => 'R$ 527,44']];
                         
        $esperado2  = [['Parcela' => 1, 'Valor' => 'R$ 28.347.070,55',  'Amortização' => 'R$ 3.597.070,55',  'Juros' => 'R$ 24.750.000,00', 'Devedor' => 'R$ 21.402.929,45'],
                       ['Parcela' => 2, 'Valor' => 'R$ 28.347.070,55',  'Amortização' => 'R$ 7.158.170,39',  'Juros' => 'R$ 21.188.900,16', 'Devedor' => 'R$ 14.244.759,07'],
                       ['Parcela' => 3, 'Valor' => 'R$ 28.347.070,55',  'Amortização' => 'R$ 14.244.759,07', 'Juros' => 'R$ 14.102.311,48', 'Devedor' => 'R$ 0,00'],
                        'Total'   =>   ['Valor' => 'R$ 85.041.211,64',  'Amortização' => 'R$ 25.000.000,00', 'Juros' => 'R$ 60.041.211,64']];

        $esperado3  = [['Parcela' => 1, 'Valor' => 'R$ 0,35',  'Amortização' => 'R$ 0,33',  'Juros' => 'R$ 0,02', 'Devedor' => 'R$ 0,67'],
                       ['Parcela' => 2, 'Valor' => 'R$ 0,35',  'Amortização' => 'R$ 0,33',  'Juros' => 'R$ 0,01', 'Devedor' => 'R$ 0,34'],
                       ['Parcela' => 3, 'Valor' => 'R$ 0,35',  'Amortização' => 'R$ 0,34',  'Juros' => 'R$ 0,01', 'Devedor' => 'R$ 0,00'],
                        'Total'   =>   ['Valor' => 'R$ 1,04',  'Amortização' => 'R$ 1,00',  'Juros' => 'R$ 0,04']];

        $resultado1 = $this->calculadora->calcularAmortizacao(25000.00,   0.7,  5, "PRICE");
        $resultado2 = $this->calculadora->calcularAmortizacao(25000000.00, 99,  3, "PRICE");
        $resultado3 = $this->calculadora->calcularAmortizacao(1.00,         2,  3, "PRICE");

        assertEquals($esperado1, $resultado1, "erro no PRICE");
        assertEquals($esperado2, $resultado2, "erro no PRICE com valores altos");
        assertEquals($esperado3, $resultado3, "erro no PRICE com valores baixos");
    }

    public function testCalcularAmortizacaoComValoresNegativos()
    {
        $esperado1  = 'O capital deve ser positivo';
        $esperado2  = 'A taxa deve ser positiva';
        $esperado3  = 'O tempo deve ser positivo';

        $resultado1 = $this->calculadora->calcularAmortizacao(-25000.00,  0.7,  5, "SAC");
        $resultado2 = $this->calculadora->calcularAmortizacao(25000.00,  -0.7,  5, "SAC");
        $resultado3 = $this->calculadora->calcularAmortizacao(25000.00,   0.7, -5, "SAC");

        $this->assertEquals($esperado1, $resultado1, "erro ao testar capital negativo");
        $this->assertEquals($esperado2, $resultado2, "erro ao testar taxa negativa");
        $this->assertEquals($esperado3, $resultado3, "erro ao testar tempo negativo");
    }

    public function testCalcularAmortizacaoComTipoErrado()
    {      
        $esperado  = "Tipo inválido, escolha entre 'SAC' ou 'PRICE'";

        $resultado = $this->calculadora->calcularAmortizacao(25000.00, 0.7, 5, "SACRE");

        $this->assertEquals($esperado, $resultado , "erro ao testar tipo errado");
    }

    public function testCalcularAmortizacaoComValoresInvalidos()
    {
        $esperado  = 'Argumento(s) invalido(s)';

        $resultado = $this->calculadora->calcularAmortizacao("a", null, [], 1);

        $this->assertEquals($esperado, $resultado, "erro ao testar valores invalidos");
    }
}
