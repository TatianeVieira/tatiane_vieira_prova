<?php
session_start();
require 'conexao.php';

if($_SESSION['perfil'] !=1) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php;'</script>";
    exit();
}

if($_SERVER["REQUEST_METHOD"] =="POST") {
    $id_fornecedor = $_POST['id_fornecedor'];
    $nome_fornecedor = $_POST['nome_fornecedor'];
    $email = $_POST['email'];
    $nova_senha = !empty($_POST['nova_senha'])? password_hash($_POST['nova_senha'], PASSWORD_DEFAULT): NULL;

    //ATUALIZA OS DADOS DO USUARIO
    if($nova_senha){
        $sql = "UPDATE fornecedor SET nome_fornecedor = :nome, email =:email = senha = :senha WHERE id_fornecedor = :id_fornecedor";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $nova_senha);
    }else{
        $sql="UPDATE fornecedor SET nome_fornecedor = :nome_fornecedor, email = :email, id_perfil = :id_perfil WHERE id_fornecedor = :id_fornecedor";
        $stmt = $pdo->prepare($sql);
    }
        $stmt->bindParam(':nome_fornecedor', $nome_fornecedor);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id_fornecedor', $id_fornecedor);

    if($stmt->execute()) {
        echo "<script>alert('Fornecedor atualizado com sucesso!');window.location.href='buscar_fornecedor.php';</script>";
    }else{
        echo "<script>alert('Erro ao atualizar Fornecedor!');window.location.href='alterar_fornecedor.php?id=$id_fornecedor';</script>";

    }
}
?>