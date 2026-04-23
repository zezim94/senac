<?php

abstract class Operacoes
{
    public static function soma($n1, $n2)
    {
        return $n1 + $n2;
    }
    public static function subtracao($n1, $n2)
    {
        return $n1 - $n2;
    }
    public static function multiplicacao($n1, $n2)
    {
        return $n1 * $n2;
    }
    public static function divisao($n1, $n2)
    {
        if ($n2 === 0) {
            return "Não pode dividir por zero";
        }
        return $n1 / $n2;
    }
}

class Calculadora extends Operacoes
{
    public static function somar($n1, $n2)
    {
        return "A soma é: " . self::soma($n1, $n2);
    }
    public static function subtrair($n1, $n2)
    {
        return "A subtração é: " . self::subtracao($n1, $n2);
    }
    public static function multiplicar($n1, $n2)
    {
        return "A multiplicação é: " . static::multiplicacao($n1, $n2);
    }
    public static function dividir($n1, $n2)
    {
        return "A divisão é: " . static::divisao($n1, $n2);
    }
}

class Calculadora2 extends Calculadora
{
    public static function divisao($n1, $n2)
    {
        if ($n2 === 0) {
            return "Não pode dividir por zero";
        }
        return ($n1 / $n2);

    }
}

echo Calculadora::somar(10, 8);
echo "<br>";
echo Calculadora::subtrair(90, 36);
echo "<br>";
echo Calculadora::multiplicar(6, 4);
echo "<br>";
echo Calculadora::dividir(60, 15);
echo "<br>";
echo Calculadora2::divisao(50, 25);
echo "<br>";
echo Calculadora::dividir(60, 25);
