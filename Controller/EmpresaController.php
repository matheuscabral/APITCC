<?php
    class EmpresaController
    {
        public function index()
        {
            try{
                $loader = new \Twig\Loader\FilesystemLoader('View');
                $twig = new \Twig\Environment($loader);
                $template = $twig->load('ViewEmpresa.html');
                $parametros = array();
                $parametros['nomeFantasia']=$_SESSION['user']['nomeFantasia'];
                $parametros['cnpj']=$_SESSION['user']['cnpj'];
                $parametros['estado']=$_SESSION['user']['estado'];
                $parametros['bairro']=$_SESSION['user']['bairro'];
                $parametros['cidade']=$_SESSION['user']['cidade'];
                $parametros['numero']=$_SESSION['user']['numero'];
                $parametros['rua']=$_SESSION['user']['rua'];
                $parametros['cep']=$_SESSION['user']['cep'];
                $parametros['complemento']=$_SESSION['user']['complemento'];
                $parametros['escopo']=$_SESSION['user']['escopo'];
                $parametros['fotos']=$_SESSION['user']['foto'];
                $conteudo = $template->render($parametros);
                echo $conteudo;
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=login"; </script>';
            }
        }

        public function editar(){
            try{
                if (isset($_POST['submit'])) {
                    $extensoesValidas = array("jpeg", "jpg", "png");
                    $extensao = pathinfo($_FILES['foto']['name'],PATHINFO_EXTENSION);
                    if(in_array($extensao, $extensoesValidas)){
                        $pasta = "fotos/";
                        $temp = $_FILES['foto']['tmp_name'];
                        $novoNome = uniqid().".".$extensao;
                        if(move_uploaded_file($temp,$pasta.$novoNome)){
                            $_POST['foto'] = "../".$pasta.$novoNome;
                            Empresa::update($_POST);
                            echo '<script> location.href="http://localhost:8080/index.php?pagina=empresa"; </script>';
                        }else{
                            echo '<script> alert("ERRO não foi possivel fazer upload"); </script>';
                            echo '<script> location.href="http://localhost:8080/index.php?pagina=empresa"; </script>';
                        }
                    }else{
                        echo '<script> alert("Formato do arquivo invalido"); </script>';
                        echo '<script> location.href="http://localhost:8080/index.php?pagina=empresa"; </script>';
                    }
                }
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=empresa"; </script>';
            }
        }
    }
?>