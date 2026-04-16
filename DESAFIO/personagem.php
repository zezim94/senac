<?php
session_start();
require_once "basePerson.php";
require_once "classImag.php";

class Personagem extends Person implements Img
{
    public $img;
    public $descricao;
    public $caracteristicas;
    public $resumo;

    public function __construct($img, $nome, $descricao, $caracteristicas, $resumo)
    {
        $this->img = $img;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->caracteristicas = $caracteristicas;
        $this->resumo = $resumo;
    }

    public function pegarImagem()
    {
        return $this->img;
    }

    function session($tipo)
    {
        $_SESSION['personagem'] = $tipo;
        $_SESSION['img'] = $this->img;
        $_SESSION['nome'] = $this->nome;
        $_SESSION['descricao'] = $this->descricao;
        $_SESSION['caracteristicas'] = $this->caracteristicas;
        $_SESSION['resumo'] = $this->resumo;
    }
}