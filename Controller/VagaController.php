<?php
    class VagaController
    {
        public function index()
        {
            try{
                $vagas = Vaga::getVagas();// acessando a model vaga
                $loader = new \Twig\Loader\FilesystemLoader('View'); // Carrega os modelos do sistema de arquivos.
                $twig = new \Twig\Environment($loader); // Armazenar a configuração e extensão do modelo
                $template = $twig->load('ViewVaga.html'); // carrega o modelo
                $parametros = array(); // Inicia a variavel parametros que a view receberá
                $parametros['vagas']=$vagas; // Seta os valores dos parametros
                $parametros['fotos']=$_SESSION['user']['foto'];
                $conteudo = $template->render($parametros); // renderiza o modelo com os parametros
                echo $conteudo; // exibi a view
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
        
        public function alter($paramId){
            try{
                Vaga::update($_POST, $paramId);
                echo '<script> alert("Vaga Alterada!"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=vaga"; </script>';
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=vaga&metodo=editar&id='.$paramId.'"; </script>';
            }
        }

        public function delete($paramId){
            try{
                Vaga::deleteVaga($paramId);
                echo '<script> alert("Vaga Deletada!"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=vaga"; </script>';
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=vaga"; </script>';
            }
        }

        public function editar($paramId){
            try{
                $vaga = Vaga::getVaga($paramId);
                $loader = new \Twig\Loader\FilesystemLoader('View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('editarVaga.html');
                $parametros = array();
                $parametros['vagas']=$vaga;
                $parametros['fotos']=$_SESSION['user']['foto'];
                $conteudo = $template->render($parametros);
                echo $conteudo;
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
            }
        }

        public function add(){
            try{
                $loader = new \Twig\Loader\FilesystemLoader('View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('addVaga.html');
                $parametros = array();
                $parametros['fotos']=$_SESSION['user']['foto'];
                $conteudo = $template->render($parametros);
                echo $conteudo;   
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
            }
        }

        public function fechar($paramId){
            try{
                $vaga = Vaga::getVaga($paramId);
                $loader = new \Twig\Loader\FilesystemLoader('View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('fecharVaga.html');
                $parametros = array();
                $parametros['vagas']=$vaga;
                $parametros['fotos']=$_SESSION['user']['foto'];
                $conteudo = $template->render($parametros);
                echo $conteudo;
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
            }
        }

        public function fecharVaga($paramId){
            try{
                Vaga::fechaVaga($paramId);
                echo '<script> alert("Vaga Fechada!"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=vaga"; </script>';
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=vaga"; </script>';
            }
        }

        public function inserir(){
            try{
                Vaga::insertVaga($_POST);
                echo '<script> alert("Vaga Cadastrada!"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=vaga"; </script>';
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=vaga&metodo=add"; </script>';
            }
        }
    }
?>