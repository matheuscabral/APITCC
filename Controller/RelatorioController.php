<?php
    class RelatorioController
    {
        public function index(){
            try{
                $loader = new \Twig\Loader\FilesystemLoader('View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('ViewRelatorio.html');
                $parametros = array();
                $parametros['fotos']=$_SESSION['user']['foto'];
                $conteudo = $template->render($parametros);
                echo $conteudo;
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }

        public function geraRelatorio(){
            try{
                $vagas = Vaga::getVagasFechadas($_POST['dataIni'],$_POST['dataFim']);
                $loader = new \Twig\Loader\FilesystemLoader('View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('ViewRelatorio.html');
                $parametros = array();
                $parametros['vagas']=$vagas;
                $parametros['fotos']=$_SESSION['user']['foto'];
                $conteudo = $template->render($parametros);
                echo $conteudo;
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=relatorio"; </script>';
            }
        }
    }
?>