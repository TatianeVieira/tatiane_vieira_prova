<?php
session_start();
require_once 'conexao.php';

//verifique se o usuario tem permissao de admin ou secreatria
if($_SESSION['perfil'] !=1 && $_SESSION['perfil']!=2 ) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

$usuario = []; //inicializa a variavel para evitar erros

//se o formulario for enviado, busca o usuario pelo ID ou NOME
if($_SERVER["REQUEST_METHOD"]== "POST" && !empty($_POST['busca'])) {
    $busca = trim($_POST['busca']);
    //verifica se a busca é um numero ou um nome
    if(is_numeric($busca)) {
        $sql = "SELECT * FROM usuario WHERE id_usuario = :busca ORDER BY nome ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    }else{
        $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome ORDER BY nome ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
    }
}else{
    $sql = "SELECT * FROM usuario ORDER BY nome ASC";
    $stmt=$pdo->prepare($sql);
}
$stmt->execute();
$usuarios = $stmt->fetchALL(PDO::FETCH_ASSOC);


?>