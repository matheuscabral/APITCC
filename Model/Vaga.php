<?php
    require_once 'conexao/conexao.php';
    require_once 'Model/Candidato.php';
    class Vaga
    {
        public static function getVagasFechadas($dataIni, $dataFim)
        {
            $date1=date_create($dataIni);
            $date2=date_create($dataFim);
            $diff = date_diff($date1, $date2);
            if($diff->format("%R%a")<0){
                throw new Exception("ERRO 28: diferença de tempo menor que 0(zero)");
            }
            $conn = Conexao::getConn();
            $sql = "select * from vaga where estatus = 'fechada' and dataCriacao >= :ini and dataCriacao <= :fim;";
            $preparando = $conn->prepare($sql);
            $preparando->bindValue(':ini', $dataIni);
            $preparando->bindValue(':fim',$dataFim);
            if($preparando->execute())
            {
                $resultado = [];
                while($row = $preparando->fetchObject('Vaga'))
                {
                    $row->id = utf8_encode($row->id);
                    $row->estatus = utf8_encode($row->estatus);
                    $row->dataCriacao = utf8_encode($row->dataCriacao);
                    $row->descricao = utf8_encode($row->descricao);
                    $row->areaInteresse = utf8_encode($row->areaInteresse);
                    $row->id_empresa = utf8_encode($row->id_empresa);
                    $row->titulo = utf8_encode($row->titulo);
                    $row->candidatos = Candidato::getSelecionados($row->id);
                    $resultado[] = $row;
                }
                return $resultado;
            }else{
                throw new Exception("ERRO 31: erra na recuperação das vagas fechadas");
            }
        }

        public static function getVagas()
        {
            $conn = Conexao::getConn();
            $sql = "select * from vaga where estatus = 'aberta' and id_empresa = :id order by dataCriacao ";
            $preparando = $conn->prepare($sql);
            $preparando->bindValue(':id',intval($_SESSION['user']['id']),PDO::PARAM_INT);
            if($preparando->execute())
            {
                $resultado = [];
                while($row = $preparando->fetchObject('Vaga'))
                {
                    $row->id = utf8_encode($row->id);
                    $row->estatus = utf8_encode($row->estatus);
                    $row->dataCriacao = utf8_encode($row->dataCriacao);
                    $row->descricao = utf8_encode($row->descricao);
                    $row->areaInteresse = utf8_encode($row->areaInteresse);
                    $row->id_empresa = utf8_encode($row->id_empresa);
                    $row->titulo = utf8_encode($row->titulo);
                    $resultado[] = $row;
                }
                return $resultado;
            }else{
                throw new Exception("ERRO 30: erra na recuperação das vagas");
            }
        }

        public static function deleteVaga($idVaga){
            $conn = Conexao::getConn();
            $sql = "delete from vaga where id = :id";
            $resultado = Candidato::deleteCV($idVaga);
            if(!$resultado == 0){
                $preparando = $conn->prepare($sql);
                $preparando->bindValue(':id',$idVaga, PDO::PARAM_INT);
                $resultado = $preparando->execute();
                if($resultado == 0){
                    throw new Exception("ERRO 47: Erro Na Operação de Delete!!");
                }
            }
            return $resultado;
        }
        
        public static function fechaVaga($idVaga){
            $conn = Conexao::getConn();
            $sql = "update vaga set estatus = :est where id = :id;";
            $preparando = $conn->prepare($sql);
            $preparando->bindValue(':est', utf8_decode("fechada"));
            $preparando->bindValue(':id',$idVaga, PDO::PARAM_INT);
            $resultado = $preparando->execute();
            if($resultado == 0){
                throw new Exception("ERRO 63: Erro na operação de fechamento da vaga ouve uma falha!!");
                return false;
            }
            return true;
        }

        public static function update($dadosVaga, $idVaga){
            if(empty($dadosVaga['titulo']) or empty($dadosVaga['descricao']) or empty($dadosVaga['areaInteresse'])){
                throw new Exception("ERRO 2: Campos obrigatorios vazios!!");
                return false;
            }
            $area = "";
            $tamanho = sizeof($dadosVaga['areaInteresse']);
            for($i = 0; $i < $tamanho; $i++){
                if($i+1 == $tamanho)
                {
                    $area .= $dadosVaga['areaInteresse'][$i];
                }else{
                    $area .= $dadosVaga['areaInteresse'][$i].';';
                }
            }
            $conn = Conexao::getConn();
            $sql = "update vaga set titulo = :tit, descricao = :desc, areaInteresse = :are where id = :id;";
            $preparando = $conn->prepare($sql);
            $preparando->bindValue(':tit', utf8_decode($dadosVaga['titulo']));
            $preparando->bindValue(':desc',utf8_decode($dadosVaga['descricao']));
            $preparando->bindValue(':are',utf8_decode($area));
            $preparando->bindValue(':id',$idVaga, PDO::PARAM_INT);
            $resultado = $preparando->execute();
            if($resultado == 0){
                throw new Exception("ERRO 48: Erro na operação de update ouve uma falha!!");
                return false;
            }
            return true;
        }

        public static function getVaga($idVaga){
            $conn = Conexao::getConn();
            $sql = "select * from vaga where id = :id";
            $preparando = $conn->prepare($sql);
            $preparando->bindValue(':id',$idVaga, PDO::PARAM_INT);
            $preparando->execute();
            $resultado = [];
            while($row = $preparando->fetchObject('Vaga'))
            {
                $row->id = utf8_encode($row->id);
                $row->estatus = utf8_encode($row->estatus);
                $row->dataCriacao = utf8_encode($row->dataCriacao);
                $row->descricao = utf8_encode($row->descricao);
                $row->areaInteresse = utf8_encode($row->areaInteresse);
                $row->id_empresa = utf8_encode($row->id_empresa);
                $row->titulo = utf8_encode($row->titulo);
                $resultado[] = $row;
            }
            if($resultado == 0){
                throw new Exception("ERRO 46: A vaga em questão não foi encontrada");
            }
            return $resultado;
        }

        public static function insertVaga($dadosVaga)
        {
            if(empty($dadosVaga['titulo']) or empty($dadosVaga['descricao']) or empty($dadosVaga['areaInteresse'])){
                throw new Exception("ERRO 2: Campos obrigatorios vazios!!");
                return false;
            }
            $area = "";
            $tamanho = sizeof($dadosVaga['areaInteresse']);
            for($i = 0; $i < $tamanho; $i++){
                if($i+1 == $tamanho)
                {
                    $area .= $dadosVaga['areaInteresse'][$i];
                }else{
                    $area .= $dadosVaga['areaInteresse'][$i].';';
                }
            }
            $conn = Conexao::getConn();
            $data = date('Y-m-d');
            $sql = "insert into vaga (estatus, descricao, areaInteresse, id_empresa, titulo, dataCriacao) values (:est, :desc, :area, :idE, :tit, :data)";
            $preparando = $conn->prepare($sql);
            $preparando->bindValue(':est', "aberta");
            $preparando->bindValue(':desc',utf8_decode($dadosVaga['descricao']));
            $preparando->bindValue(':area',utf8_decode($area));
            $preparando->bindValue(':idE', 1);
            $preparando->bindValue(':tit', utf8_decode($dadosVaga['titulo']));
            $preparando->bindValue(':data',$data);
            $resultado = $preparando->execute();

            if($resultado == 0){
                throw new Exception("ERRO 44: Erro na operação de insert ouve uma falha!!");
                return false;
            }
            return true;
        }
    }
?>