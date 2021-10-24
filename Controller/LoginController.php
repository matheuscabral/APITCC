<?php
    
    class LoginController
    {
        public function index()
        {
            $loader = new \Twig\Loader\FilesystemLoader('View');
            $twig = new \Twig\Environment($loader,[
                'cache' => '/path/to/compilation_cache',
                'auto_reload' => true,
            ]);
            $template = $twig->load('login.html');
            $conteudo = $template->render();
            echo $conteudo;
        }

        public function check(){
            try{
                Empresa::login($_POST);
                echo '<script> location.href="http://localhost:8080/index.php?pagina=empresa"; </script>';
            }catch(Exception $e){
                echo '<script> alert("'.$e->getMessage().'"); </script>';
                echo '<script> location.href="http://localhost:8080/index.php?pagina=login"; </script>';
            }   
        }
    }
?>