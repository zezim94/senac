<?php

require_once 'personagem.php';

function personagem($tipo)
{
    switch ($tipo) {

        case 'Mickey':
            return new Personagem(
                'img/mickey.jpg',
                'Mickey Mouse',
                'Personagem clássico da Disney.',
                [
                    'Orelhas redondas',
                    'Roupa vermelha',
                    'Luvas brancas'
                ],
                'Criado por Walt Disney, é o mascote oficial da Disney.'
            );

        case 'SpongeBob':
            return new Personagem(
                'img/bobesponja.jpg',
                'Bob Esponja',
                'Esponja que vive no fundo do mar.',
                [
                    'Calça quadrada',
                    'Trabalha no Siri Cascudo',
                    'Muito otimista'
                ],
                'Vive na Fenda do Biquíni com seus amigos.'
            );

        case 'Goku':
            return new Personagem(
                'img/goku.png',
                'Goku',
                'Guerreiro Saiyajin.',
                [
                    'Super força',
                    'Transformações',
                    'Ama lutar'
                ],
                'Protagonista de Dragon Ball.'
            );

        case 'Naruto':
            return new Personagem(
                'img/naruto.jpg',
                'Naruto Uzumaki',
                'Ninja da Vila da Folha.',
                [
                    'Raposa de nove caudas',
                    'Rasengan',
                    'Nunca desiste'
                ],
                'Sonha em se tornar Hokage.'
            );

        case 'Batman':
            return new Personagem(
                'img/batman.jpg',
                'Batman',
                'Herói de Gotham.',
                [
                    'Sem poderes',
                    'Muito inteligente',
                    'Usa gadgets'
                ],
                'Combate o crime usando estratégia e tecnologia.'
            );

        case 'Elsa':
            return new Personagem(
                'img/elsa.jpg',
                'Elsa',
                'Rainha do gelo.',
                [
                    'Poderes de gelo',
                    'Canta "Let It Go"',
                    'Controla neve'
                ],
                'Personagem do filme Frozen.'
            );

        case 'Shrek':
            return new Personagem(
                'img/shrek.jpg',
                'Shrek',
                'Ogro que vive no pântano.',
                [
                    'Grande e forte',
                    'Mal-humorado',
                    'Coração bom'
                ],
                'Vive aventuras com o Burro.'
            );

        case 'Homer':
            return new Personagem(
                'img/homer.png',
                'Homer Simpson',
                'Pai da família Simpson.',
                [
                    'Ama donuts',
                    'Trabalha na usina',
                    'Engraçado'
                ],
                'Personagem de Os Simpsons.'
            );

        default:
            return null;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['personagem']) || empty($_POST['personagem'])) {
        header('Location: index.php');
        exit;
    }

    $tipo = $_POST['personagem'];

    $personagem = personagem($tipo);

    if (!$personagem) {
        header('Location: index.php');
        exit;
    }

    $personagem->session($tipo);

    header('Location: index.php');
    exit;
}