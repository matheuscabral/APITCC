<?php
    class CandidatoController{

        public function index($paramId){
            try{
                $candidatos = Candidato::getCandidatos($paramId);
                $loader = new \Twig\Loader\FilesystemLoader('View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('ViewCandidato.html');
                $parametros = array();
                $parametros['candidatos']=$candidatos;
                $parametros['fotos']=$_SESSION['user']['foto'];
                $conteudo = $template->render($parametros);
                echo $conteudo;
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=vaga"; </script>';
            }
        }

        public function enviar($paramId){
            try{
                $loader = new \Twig\Loader\FilesystemLoader('View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('emailCandidatos.html');
                $parametros['idVaga']=$paramId;
                $parametros['fotos']=$_SESSION['user']['foto'];
                $conteudo = $template->render($parametros);
                echo $conteudo;
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=vaga"; </script>';
            }
        }

        public function email($paramId){
            try{
                Candidato::getEmailSelecionados($paramId, $_POST);
                echo '<script> alert("E-mail Enviado!"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=vaga&metodo=fechar&id='.$paramId.'"; </script>';
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=vaga"; </script>';
            }
        }

        
        public function selecionados(){
            try{
                Candidato::updateCandidatosSelec($_POST);
                $resultado = Candidato::pegaVaga($_POST);
                $loader = new \Twig\Loader\FilesystemLoader('View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('selecionados.html');
                $parametros['idVaga']=$resultado;
                $parametros['fotos']=$_SESSION['user']['foto'];
                $conteudo = $template->render($parametros);
                echo $conteudo;
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=vaga"; </script>';
            }
        }
    }
?>