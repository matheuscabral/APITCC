<?php
    session_start();
    require_once 'Core/Core.php';
    require_once 'conexao/conexao.php';
    require_once 'Controller/EmpresaController.php';
    require_once 'Controller/ErroController.php';
    require_once 'Controller/VagaController.php';
    require_once 'Controller/CandidatoController.php';
    require_once 'Controller/LoginController.php';
    require_once 'Controller/HomeController.php';
    require_once 'Model/Empresa.php';
    require_once 'Model/Vaga.php';
    require_once 'Model/Candidato.php';
    require_once 'vendor/autoload.php';

    //$template = file_get_contents('View\login.html');

    //ob_start();
        $core = new Core;
        echo $core->start($_GET);
        //$saida = ob_get_contents();
    //ob_end_clean();
    //$tplPronto = str_replace('{{conteudo do menu}}', $saida, $template);
    
    //echo $tplPronto;
?> 