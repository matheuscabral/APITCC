<?php
    class Core
    {
        public function start($urlGet)
        {
            if(isset($urlGet['pagina'])){
                $controller = ucfirst($urlGet['pagina']."Controller");
                if (!class_exists($controller))
                {
                    $controller = 'ErroController';
                }
            }else
            {
                if(isset($_SESSION['user'])){
                    $controller = 'EmpresaController';
                }else{
                    $controller = 'LoginController';
                }
            }
            if(isset($urlGet['metodo'])){
                $acao = $urlGet['metodo'];
            }else{
                $acao = 'index';
            }

            if(isset($urlGet['id']) && $urlGet['id'] != null){
                $id = $urlGet['id'];
            }else{
                $id = null;
            }

            return call_user_func_array(array(new $controller, $acao),array('id' => $id));
        }
    }