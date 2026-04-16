<?php

abstract class Person
{

    public $nome, $caracteristica;

    public function __construct($nome, $caracteristica)
    {
        $this->nome = $nome;
        $this->caracteristica = $caracteristica;
    }
}