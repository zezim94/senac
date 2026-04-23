<?php

abstract class Person
{

    public $nome, $caracteristicas;

    public function __construct($nome, $caracteristicas)
    {
        $this->nome = $nome;
        $this->caracteristicas = $caracteristicas;
    }
}