<?php
session_start();
require 'conexao.php';

//verifica se o usuario tem permissao de admin
if($_SESSION['perfil'] !=1) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

//inicializa variavel para aramazenar usuario
$usuarios = [];

//busca todos os usuarios cadastrados em ordem alfabetica
$sql = "SELECT * FROM usuarios ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

//se um ID for passado via get exclui o usuario
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = $_GET['id'];

    //exclui o usuario do banco dados
    $sql = "DELETE usuario WHERE id_usuario = :id";
    $stmt= $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::FETCH_INT);

    if($stmt->execute()) {
        echo "<script>alert('Usuario excluido com sucerro!');window.location.href='excluir_usuario.php';</script>";
    }else{
        echo "<script>alert('Erro ao excluir o usuario!');</script>";
    }
}
?>