<?php
    class HomeController{
        public function index(){
;
        }

        public function logout()
        {
            session_destroy();
            echo '<script> location.href="http://localhost:8080/index.php?pagina=login"; </script>';
        }
    }
?>