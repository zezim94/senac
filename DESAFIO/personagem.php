<?php
session_start();
require_once "basePerson.php";
require_once "classImag.php";

class Personagem extends Person implements Img
{
    public $img;
    public $descricao;
    public $resumo;

    public function __construct($img, $nome, $descricao, $caracteristicas, $resumo)
    {
        parent::__construct($nome, $caracteristicas);

        $this->img = $img;
        $this->descricao = $descricao;
        $this->resumo = $resumo;
    }

    public function pegarImagem()
    {
        return $this->img;
    }

    function session($tipo)
    {
        $_SESSION['personagem'] = $tipo;
        $_SESSION['img'] = $this->pegarImagem();
        $_SESSION['nome'] = $this->nome;
        $_SESSION['descricao'] = $this->descricao;
        $_SESSION['caracteristicas'] = $this->caracteristicas;
        $_SESSION['resumo'] = $this->resumo;
    }
}