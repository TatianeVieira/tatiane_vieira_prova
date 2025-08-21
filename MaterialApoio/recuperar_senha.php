<?php
session_start();
require_once 'conexao.php';
require_once 'funcoes_email.php'; //arquivo com as funcoes que segram as senhas e simulam o envio

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email=$_POST['email'];

    //verofoca se o email existe no bd
    $sql="SELECT * FROM usuario WHERE email = :email";
    $stmt= $pdo->prepare($sql);
    $stmt->bindParam(':email',$email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if($usuario) {
        //gera uma senha temporaria e aleatoria
        $senha_temporaria = gerarSenhaTemporaria();
        $senha_hash = password_hash($senha_temporaria, PASSWORD_DEFAULT);

        //ATUALIZA A SENHA DO USUARIO NO BD
        $sql="UPDATE usuario SET senha = :senha, senha_temporaria = TRUE  WHERE email = :email";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':senha',$senha_hash);
        $stmt->bindParam(':email',$email);
        $stmt->execute();

        //simula o envio do email (grava em txt)
        simularEnvioEmail($email, $senha_temporaria);
        echo "<script>alert('Uma senha temporaria foi gerada e enviada (simulacao).Verifique o arquivo emails_simulados.txt'); window.location.href='index.php';</script>";
    }else{
        echo "<script>alert('Email nao encontrado');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Recuperar senha</h2>
    <form action="recuperar_senha.php" method="POST">
        <label for="email">Digite seu email cadastrado</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Enviar a senha temporaria</button>
    </form>
    <center>
    <address>
        Tatiane Vieira / Estudante / Tecnico em Deenvolvimento de Sistemas
    </address>
</center>
</body>
</html>