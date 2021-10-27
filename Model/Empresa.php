<?php
    require_once 'conexao/conexao.php';
    class Empresa
    {
        public static function login($dados)
        {
            $conn = conexao::getConn();
            $sql = "select * from empresa e inner join endereco en on e.id_endereco = en.id where e.email = :email  and senha  = :senha";
            $preparando = $conn->prepare($sql);
            $preparando->bindValue(':email',$dados['email']);
            $preparando->bindValue(':senha',$dados['senha']);
            if($preparando->execute()){
                if($preparando->rowCount()){
                    $row = $preparando->fetchObject('Empresa');
                    $_SESSION['user'] = array(
                        'id' => $row->id,
                        'id_endereco' => $row->id_endereco,
                        'nomeFantasia' => utf8_encode($row->nomeFantasia),
                        'email' => utf8_encode($row->email),
                        'senha' => utf8_encode($row->senha),
                        'estatus' => utf8_encode($row->estatus),
                        'cnpj' => utf8_encode($row->cnpj),
                        'escopo' => utf8_encode($row->escopo),
                        'foto' => utf8_encode($row->foto),
                        'rua' => utf8_encode($row->rua),
                        'estado' => utf8_encode($row->estado),
                        'cidade' => utf8_encode($row->cidade),
                        'numero' => utf8_encode($row->numero),
                        'cep' => utf8_encode($row->cep),
                        'bairro' => utf8_encode($row->bairro),
                        'complemento' => utf8_encode($row->complemento)
                    );
                    return true;
                }
            }
            throw new Exception ("ERRO 0: Login Invalido");
        }

        public static function update($dados){
            if(empty($dados['nomeFantasia']) or empty($dados['cnpj']) or empty($dados['estado']) or empty($dados['cidade']) or empty($dados['rua']) or empty($dados['bairro']) or empty($dados['numero']) or empty($dados['cep']) or empty($dados['complemento']) or empty($dados['escopo']) or empty($dados['foto'])){
                throw new Exception("ERRO 2: Campos obrigatorios vazios!!");
            }
            $conn = Conexao::getConn();
            $sql1 = "update empresa set nomeFantasia = :nome, cnpj = :cnpj, escopo = :esc, foto = :foto where id = :id;";
            $sql2 = "update endereco set rua = :rua, estado = :est, cidade = :cid, cep = :cep, numero = :num, bairro = :bai, complemento = :comp where id = :id;";
            $preparando = $conn->prepare($sql2);
            $preparando->bindValue(':rua',$dados['rua']);
            $preparando->bindValue(':est',$dados['estado']);
            $preparando->bindValue(':cid',$dados['cidade']);
            $preparando->bindValue(':cep',$dados['cep']);
            $preparando->bindValue(':num',$dados['numero']);
            $preparando->bindValue(':bai',$dados['bairro']);
            $preparando->bindValue(':comp',$dados['complemento']);
            $preparando->bindValue(':id',$_SESSION['user']['id_endereco'], PDO::PARAM_INT);
            if($preparando->execute()){
                $preparando = $conn->prepare($sql1);
                $preparando->bindValue(':nome',utf8_decode($dados['nomeFantasia']));
                $preparando->bindValue(':cnpj',$dados['cnpj']);
                $preparando->bindValue(':esc',utf8_decode($dados['escopo']));
                $preparando->bindValue(':foto',$dados['foto']);
                $preparando->bindValue(':id',$_SESSION['user']['id'], PDO::PARAM_INT);
                if($preparando->execute()){
                    $_SESSION['user']['nomeFantasia'] = utf8_encode($dados['nomeFantasia']);
                    $_SESSION['user']['cnpj'] = $dados['cnpj'];
                    $_SESSION['user']['escopo'] = $dados['escopo'];
                    $_SESSION['user']['foto'] = $dados['foto'];
                    $_SESSION['user']['rua'] = $dados['rua'];
                    $_SESSION['user']['estado'] = $dados['estado'];
                    $_SESSION['user']['cidade'] = $dados['cidade'];
                    $_SESSION['user']['cep'] = $dados['cep'];
                    $_SESSION['user']['numero'] = $dados['numero'];
                    $_SESSION['user']['bairro'] = $dados['bairro'];
                    $_SESSION['user']['complemento'] = $dados['complemento'];
                    return;
                }else{
                    throw new Exception("ERRO 2: ouve um erro durante a operação de update!!");
                }
            }else{
                throw new Exception("ERRO 1: ouve um erro durante a operação de update!!");
            }
        }
    }
?>