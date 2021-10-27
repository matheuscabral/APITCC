<?php
    require_once 'conexao/conexao.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class Candidato{

        public static function getEmailSelecionados($idVaga, $dados){
            $conn = Conexao::getConn();
            $sql = "select p.emailEstudante from candidato c inner join perfil p on c.matriculaEstudante = p.matriculaEstudante where c.estadoVaga = 'selecionado' and c.id_vaga = :idv;";
            $preparando = $conn->prepare($sql);
            $preparando->bindValue(':idv',$idVaga, PDO::PARAM_INT);
            $preparando->execute();
            $resultado = [];
            while($row = $preparando->fetchObject('Candidato')){
                $row->emailEstudante = utf8_encode($row->emailEstudante);
                $resultado[] = $row;
            }
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'carreirasuvv123@gmail.com';
            $mail->Password = 'jinzo100';         
            $mail->Port = '587';
            $mail->CharSet = 'UTF-8';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->IsHTML(false);
            $mail->setFrom('carreirasuvv123@gmail.com');
            $tamanho = sizeof($resultado);
            for($i = 0; $i < $tamanho; $i++){
                $email = $resultado[$i]->emailEstudante;
                $mail->AddCC($email);
            }
            $mail->Subject = $dados['titulo'];
            $mail->Body = $dados['corpo'];
            if($mail->send()){
            }else{
                throw new Exception("ERRO 70! Erro ao enviar o E-mail para os candidatos");
            }
        }

        public static function getSelecionados($idVaga){
            $conn = Conexao::getConn();
            $sql = "select c.id,c.matriculaEstudante,p.curriculo,p.areaInteresse,c.id_vaga from candidato c inner join perfil p on c.matriculaEstudante = p.matriculaEstudante where c.id_vaga = :id and c.estadoVaga = :estado;";
            $preparando = $conn->prepare($sql);
            $preparando->bindValue(':id',$idVaga, PDO::PARAM_INT);
            $preparando->bindValue(':estado',"selecionado");
            $preparando->execute();
            $resultado = [];
            while($row = $preparando->fetchObject('Candidato')){
                $row->id = utf8_encode($row->id);
                $row->matriculaEstudante = utf8_encode($row->matriculaEstudante);
                $row->areaInteresse = utf8_encode($row->areaInteresse);
                $row->curriculo = utf8_encode($row->curriculo);
                $resultado[] = $row;
            }
            return $resultado;
        }

        public static function getCandidatos($idVaga){
            $conn = Conexao::getConn();
            $sql = "select c.id,c.matriculaEstudante,p.curriculo,p.areaInteresse,c.id_vaga from candidato c inner join perfil p on c.matriculaEstudante = p.matriculaEstudante where c.id_vaga = :id and c.estadoVaga != :estado;";
            $preparando = $conn->prepare($sql);
            $preparando->bindValue(':id',$idVaga, PDO::PARAM_INT);
            $preparando->bindValue(':estado',"selecionado");
            $preparando->execute();
            $resultado = [];
            while($row = $preparando->fetchObject('Candidato')){
                $row->id = utf8_encode($row->id);
                $row->matriculaEstudante = utf8_encode($row->matriculaEstudante);
                $row->areaInteresse = utf8_encode($row->areaInteresse);
                $row->curriculo = utf8_encode($row->curriculo);
                $resultado[] = $row;
            }
            return $resultado;
        }

        public static function pegaVaga($dados){
            $conn = Conexao::getConn();
            $sql = "select id_vaga from candidato where id = :id";
            $preparando = $conn->prepare($sql);
            $preparando->bindValue(':id',$dados['escolhido'][0], PDO::PARAM_INT);
            $resultado = $preparando->execute();
            return $resultado;
        }
        
        public static function updateCandidatosSelec($dados){
            if(empty($dados['escolhido'])){
                throw new Exception("ERRO 60! Nenhum candidato selecionado!");
            }
            $tamanho = sizeof($dados['escolhido']);
            $conn = Conexao::getConn();
            $sql = "update candidato set estadoVaga = :selec, dataAltEst = :date where id = :id;";
            for($i = 0; $i < $tamanho; $i++){
                
                $preparando = $conn->prepare($sql);
                $preparando->bindValue(':selec',"selecionado");
                $preparando->bindValue(':date',date('Y-m-d'));
                $preparando->bindValue(':id',$dados['escolhido'][$i], PDO::PARAM_INT);
                $preparando->execute();
            }
            return true;
        }

        public static function deleteCV($idVaga){
            $conn = Conexao::getConn();
            $sql = "delete from candidato where id_vaga = :id";
            $preparando = $conn->prepare($sql);
            $preparando->bindValue(':id',$idVaga, PDO::PARAM_INT);
            $resultado = $preparando->execute();
            if($resultado == 0){
                throw new Exception("ERRO 45: Erro Na Operação de Delete!!");
            }
            return $resultado;
        }
    }
?>